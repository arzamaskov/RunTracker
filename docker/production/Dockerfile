# ========================
# Base (PHP-FPM + расширения)
# ========================
FROM php:8.4-fpm-alpine AS base

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
    # Очистка: удаление build-зависимостей и кеша
    && apk del .build-deps \
    && rm -rf /tmp/pear \
    && rm -rf /var/cache/apk/*

# Установка Composer
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# ========================
# Assets (сборка фронтенда)
# ========================
FROM node:22-alpine AS assets

WORKDIR /app

# Кешируем node-зависимости
COPY package.json pnpm-lock.yaml ./
# Включаем corepack и используем pnpm
RUN corepack enable \
    && pnpm install --frozen-lockfile

# Копируем код и собираем фронтенд
COPY . .
RUN pnpm run build

# Результат: /app/public/build

# ========================
# Production (PHP-FPM + собранные assets)
# ========================
FROM base AS prod

WORKDIR /var/www/html

# Настройка PHP для production (отдельный prod ini)
COPY docker/php-fpm/php.prod.ini /usr/local/etc/php/conf.d/custom.ini

# 1) Кеш Composer зависимостей
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --no-scripts --no-autoloader

# 2) Код приложения
COPY . .

# .env не кладём в образ
RUN rm -f .env || true

# 3) Готовые фронт-ассеты из стадии assets
COPY --from=assets /app/public/build ./public/build

# 4) Финальный composer + права
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader \
    && mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R ug+rw storage bootstrap/cache \
    && composer clear-cache

# config:cache/route:cache запускаем на деплое, когда есть ENV
EXPOSE 9000
# Запуск под непривилегированным пользователем
USER www-data
CMD ["php-fpm"]

# ========================
# Web (nginx для статики)
# ========================
FROM nginx:1.28-alpine AS web

WORKDIR /var/www/html

# Копируем только public с собранными ассетами из prod стадии
COPY --from=prod /var/www/html/public ./public

# Копируем nginx конфиг для Laravel
COPY docker/nginx/production.conf /etc/nginx/conf.d/default.conf
