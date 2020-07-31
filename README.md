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

# Performance

```
$ npm install -g artillery
$ artillery run ./benchmark/artillery.yml
```
