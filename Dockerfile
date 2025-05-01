FROM php:8.4-cli

# install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libzip4 \
    libssl-dev \
    unzip \
    git \
    curl \
    && rm -rf /var/lib/apt/lists/* \
    && apt-get clean \
    && pecl install mongodb \
    && docker-php-ext-install zip \
    && docker-php-ext-enable mongodb

COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer
RUN chmod +x /usr/bin/composer

RUN mkdir /.composer && chown ${UID:-1000}:${GID:-1000} /.composer
WORKDIR /app

EXPOSE 80

CMD ["php", "-S", "0.0.0.0:80", "-t", "/app/public"]
