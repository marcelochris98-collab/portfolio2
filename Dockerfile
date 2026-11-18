FROM php:8.3-cli-alpine

RUN apk add --no-cache sqlite-libs sqlite-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite

WORKDIR /app
COPY . /app

RUN mkdir -p /app/sql /app/img/projects \
    && chmod -R 777 /app/sql /app/img/projects

EXPOSE 8080

CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-8080}"]
