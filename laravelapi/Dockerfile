FROM php:7.4-fpm

WORKDIR /var/www

RUN apt-get update -y && apt-get install -y openssl zip unzip git

# install composer
ENV COMPOSER_HOME /composer
ENV PATH ./vendor/bin:/composer/vendor/bin:$PATH
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo mbstring \
    bcmath \
    calendar \
    curl \
    exif \
    gd \
    iconv \
    intl \
    mbstring \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    pdo_sqlite \
    pcntl \
    tokenizer \
    xml \
    zip

# clean cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# copy applications codes to working directory
COPY . /var/www
ADD ./public /var/www/html

RUN composer install

# expose port
EXPOSE 8000

# run application
CMD php artisan serve --host=0.0.0.0 --port=8000