# https://github.com/hyperf/hyperf-docker
FROM hyperf/hyperf:7.4-alpine-v3.10-cli

##
# ---------- env settings ----------
##
# --build-arg TIMEZONE=Europe/Madrid --build-arg PORT=9500
ARG TIMEZONE=UTC
ARG COMPOSER_VERSION=1.9.0
ARG PORT=9501
ARG ENV=prod

ENV APP_COMPOSER_VERSION=${COMPOSER_VERSION} \
    APP_ENV=${ENV} \
    PHP_TIMEZONE=${TIMEZONE} \
    PHP_MEMORY_LIMIT=-1 \
    PHP_POST_MAX_SIZE=108M \
    PHP_UPLOAD_MAX_FILESIZE=100M \
    MSGPACK_VERSION=2.0.3

# update
RUN set -ex \
    && apk update \
    # install msgpack
    && apk add --no-cache libstdc++ openssl git bash \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS libaio-dev openssl-dev \
    && cd /tmp \
    && curl -L -o msgpack.tar.gz https://github.com/msgpack/msgpack-php/archive/msgpack-${MSGPACK_VERSION}.tar.gz \
    && ls -alh \
    && cd /tmp \
    && mkdir -p msgpack \
    && tar -xf msgpack.tar.gz -C msgpack --strip-components=1 \
    && ln -s /usr/bin/phpize7 /usr/local/bin/phpize \
    && ln -s /usr/bin/php-config7 /usr/local/bin/php-config \
    && ( \
        cd msgpack \
        && phpize \
        && ./configure --with-php-config=/usr/local/bin/php-config \
        && make -s -j$(nproc) && make install \
    ) \
    && echo "extension=msgpack.so" > /etc/php7/conf.d/50_msgpack.ini \
    && php --ri msgpack \
    # install composer
    && cd /tmp \
    && wget https://github.com/composer/composer/releases/download/${APP_COMPOSER_VERSION}/composer.phar \
    && chmod u+x composer.phar \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update --clean-backups \
    # show php version and extensions
    && php -v \
    && php -m \
    #  ---------- some config ----------
    && cd /etc/php7 \
    && mkdir -p /var/log/php \
    # - config PHP
    && { \
        echo "upload_max_filesize=${PHP_UPLOAD_MAX_FILESIZE}"; \
        echo "post_max_size=${PHP_POST_MAX_SIZE}"; \
        echo "memory_limit=${PHP_MEMORY_LIMIT}"; \
        echo "date.timezone=${PHP_TIMEZONE}"; \
    } | tee conf.d/99-overrides.ini \
    # - config timezone
    && ln -sf /usr/share/zoneinfo/${PHP_TIMEZONE} /etc/localtime \
    && echo "${PHP_TIMEZONE}" > /etc/timezone \
    # ---------- clear works ----------
    && apk del .build-deps \
    && rm -rf /var/cache/apk/* /tmp/* /usr/share/man \
    && composer global require hirak/prestissimo \
    && echo -e "\033[42;37m Build Completed :).\033[0m\n"

COPY . /var/www/app
WORKDIR /var/www/app

RUN mv composer-auth.json /root/.composer/auth.json
RUN composer install --no-dev -o

EXPOSE ${PORT}

CMD ["php", "/var/www/app/bin/hyperf.php", "start"]