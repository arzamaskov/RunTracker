FROM php:8.4-fpm-alpine

# Установка зависимостей и компиляция расширений в одном слое для уменьшения размера
RUN apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        freetype-dev \
        g++ \
        gcc \
        icu-dev \
        libc-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        libxml2-dev \
        libzip-dev \
        linux-headers \
        make \
        oniguruma-dev \
        pcre-dev \
        postgresql-dev \
        zlib-dev \
    # Установка runtime зависимостей
    && apk add --no-cache \
        bash \
        curl \
        freetype \
        git \
        icu-libs \
        libjpeg-turbo \
        libpng \
        libpq \
        libxml2 \
        libzip \
        oniguruma \
        postgresql-client \
        zlib \
    # Компиляция PHP расширений
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        exif \
        gd \
        intl \
        mbstring \
        opcache \
        pdo \
        pdo_pgsql \
        pcntl \
        xml \
        zip \
    # Установка Redis через PECL
    && pecl install redis \
    && docker-php-ext-enable redis \
    # Установка Xdebug через PECL (для разработки)
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    # Очистка: удаление build-зависимостей и кеша
    && apk del .build-deps \
    && rm -rf /tmp/pear \
    && rm -rf /var/cache/apk/*

# Установка Composer
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# Настройка PHP
COPY docker/php-fpm/php.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker/php-fpm/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Создание пользователя
RUN addgroup -g 1000 laravel && adduser -D -u 1000 -G laravel laravel

# Установка рабочей директории
WORKDIR /var/www/html

# Права доступа
RUN chown -R laravel:laravel /var/www/html

USER laravel

EXPOSE 9000

CMD ["php-fpm"]
