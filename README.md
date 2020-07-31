# Installation

Execute the following command to create a copy of the `wallbox` project.

## Prepare the project:
```
cd www
git clone git@github.com:ivannis/wallbox.git wallbox
cd wallbox
cp .env.example .env
cp composer-auth.json.example composer-auth.json
# At this point, generate a token and add it to the composer-auth.json file 
```

Build and run the docker engine:

```
# Build the Hyperf image
docker-compose build
docker network create traefik_webgateway
docker-compose up -d
```

## What's inside?

Within the `src` directory, you can find the different contexts of the application

### [Common](/src/Common)

Common utilities across all contexts

### [Downloader](/src/Downloader)

Context dedicated to download and import data from the CSV file  

### [Wallbox](/src/Wallbox)

Context dedicated to users

## Install the project:

```
# Run the following commands within the wallbox container
docker exec -it wallbox sh
composer install
bin/task migrate # or execute `php bin/hyperf.php migrate:fresh --database=default --path=migrations`
```

## Start server

```
docker-compose up -d
docker exec -it wallbox sh
php bin/hyperf.php start
# press CTRL + C to terminate the current process
```

## Import users

Open another terminal and type the following:

```
docker exec -it wallbox sh
php bin/hyperf.php import:users
```

You can now use API at the endpoint: `http://api.localhost/v1`.

# Documentation

Open the swagger editor url https://editor.swagger.io and paste the content within the `swagger.yaml` file in the root directory

# Tests

```
$ bin/behat
```

## Coverage
```
$ bin/task coverage
# now open runtine/coverage/html/index.html
```

# How to scale

In the production environment we are not going to use docker-compose to deploy the system. We are going to use [terraform](https://www.terraform.io/) to create the infrastructure and [nomad](https://www.nomadproject.io/) as deployment orchestrator.

To test the scalability of the system in development, we can simply do the following:

```
$ docker-compose down
```

Now you can comment the line#77 on the `docker-compose.yml` file

```
  wallbox:
#    container_name: wallbox
    command: php -S 127.0.0.1:13300
    build:
  ...
```

Run the following command:

```
$ docker-compose up -d --scale wallbox=3
$ docker-compose ps
```

## Start 3 servers

Open terminal 1:
```
docker exec -it wallbox_wallbox_1 sh
php bin/hyperf.php start
# press CTRL + C to terminate the current process
```

Open terminal 2:
```
docker exec -it wallbox_wallbox_2 sh
php bin/hyperf.php start
# press CTRL + C to terminate the current process
```

Open terminal 3:
```
docker exec -it wallbox_wallbox_3 sh
php bin/hyperf.php start
# press CTRL + C to terminate the current process
```

Now you can perform a request to the API to see how the servers will balance the workload.

Open terminal 4:
```
curl --location --request GET 'http://api.localhost/v1/users/' \
--header 'Content-Type: application/json' \
--data-raw ''
```

# Performance

```
$ npm install -g artillery
$ artillery run ./benchmark/artillery.yml
```

# TODO
- Add units and functional tests (coming soon)
- Return paginated user list
- Add a cron job to import users every X hours
- Create a pipeline for a continuous integration system
- Create a deployment configuration