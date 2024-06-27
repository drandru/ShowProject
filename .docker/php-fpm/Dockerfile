FROM php:8.2-fpm

WORKDIR "/app"

ARG DOCKER_GID=1000
ARG DOCKER_UID=1000

# настройка пользователя и прав
RUN groupadd -g $DOCKER_GID docker
RUN useradd -g $DOCKER_GID -u $DOCKER_UID docker

# установка необходимых пакетов
RUN apt-get update \
    && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libzip-dev \
        libpng-dev \
        libpq-dev \
        git \
    && apt-get clean
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*


# установка php расширений
RUN docker-php-ext-install bcmath exif pcntl zip

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_pgsql

RUN pecl install redis xdebug \
    && docker-php-ext-enable redis.so xdebug

COPY .docker/php-fpm/php-ini-overrides.ini /usr/local/etc/php/conf.d/99-overrides.ini

COPY --chown=docker:docker .docker/php-fpm/docker-entrypoint.sh /docker-entrypoint.sh

USER docker

ENTRYPOINT /docker-entrypoint.sh
