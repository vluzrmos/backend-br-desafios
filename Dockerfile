FROM php:8.4-cli

COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer
RUN chmod +x /usr/bin/composer

WORKDIR /app

EXPOSE 80

CMD ["php", "-S", "0.0.0.0:80", "-t", "/app/public"]
