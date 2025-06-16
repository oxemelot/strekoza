FROM php:8.3-fpm

ARG APP_UID
ARG APP_GID
ARG APP_ENV
ARG XDEBUG_PORT

# Создание пользователя
RUN groupadd -g ${APP_GID} app \
 && useradd -m -u ${APP_UID} -g app app

# Установка зависимостей и расширений
RUN apt-get update && apt-get install -y \
    git zip unzip curl libpq-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring xml

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libmagickwand-dev --no-install-recommends \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && pecl install imagick \
    && docker-php-ext-enable imagick

# Установка Xdebug только если dev
RUN if [ "${APP_ENV}" = "dev" ]; then \
      pecl install xdebug && \
      docker-php-ext-enable xdebug && \
      { \
        echo "zend_extension=xdebug.so"; \
        echo "xdebug.mode=debug"; \
        echo "xdebug.start_with_request=yes"; \
        echo "xdebug.client_host=host.docker.internal"; \
        echo "xdebug.client_port=${XDEBUG_PORT}"; \
        echo "xdebug.idekey=PHPSTORM"; \
      } > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    fi

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Рабочая директория
WORKDIR /var/www
RUN chown -R ${APP_UID}:${APP_GID} /var/www

# Запуск от пользователя
USER app
