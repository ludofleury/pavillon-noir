FROM php:7.4-fpm AS base

RUN apt-get update && \
  # zip/unzip: easing composer deps fetching
  apt-get install -y zip unzip libzip-dev  && docker-php-ext-install zip \
  # database: PostgreSQL
  && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/app

##############################################################################################################
FROM base AS dev

RUN pecl install xdebug

ENV APP_ENV=dev

RUN docker-php-ext-enable xdebug \
  echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  && echo "xdebug.remote_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  && echo "xdebug.remote_handler=dbgp" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  && echo "xdebug.remote_connect_back=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  && echo "xdebug.idekey=xdebug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  && echo "xdebug.remote_host=docker.for.mac.localhost" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini 

##############################################################################################################
FROM base as test

RUN pecl install xdebug

ENV APP_ENV=test

# PHP dependencies fetching (docker layer optimisation)
COPY composer.* /var/app/
RUN composer install --dev --no-scripts && rm -rf /root/.composer

# PHP app bootstrap
COPY . /var/app
RUN php bin/console cache:clear

# Enable xdebug last to optimize previous steps performance
RUN docker-php-ext-enable xdebug 

##############################################################################################################
FROM base AS prod

ENV APP_ENV=prod

COPY . /var/app
RUN composer install --no-dev --optimize-autoloader && rm -rf /root/.composer

