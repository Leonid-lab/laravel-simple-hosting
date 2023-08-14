FROM php:8.2-fpm

WORKDIR /var/www/html

# Обновление последних пакетов и установка необходимых зависимостей для проекта
RUN apt-get update && apt-get install -y \
  git \
  zip \
  unzip \
  && rm -rf /var/lib/apt/lists/* \
  && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
  && docker-php-ext-install pdo pdo_mysql


# Установка Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Настройка конфигурации Xdebug
RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini


# Создание папок storage и bootstrap/cache
RUN mkdir -p storage/framework/{cache,sessions,views} \
    storage/logs \
    bootstrap/cache

# Выставление прав на эти папки для чтения/записи файлов
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

CMD ["php-fpm"]

EXPOSE 9000
