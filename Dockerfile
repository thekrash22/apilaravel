FROM php:8.1.3-fpm

ARG user
ARG uid

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    zip \
    unzip \
    libmagickwand-dev --no-install-recommends

RUN apt-get clean && rm -rf /var/lib/apt/lists/*


RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath
#RUN docker-php-ext-install dom
RUN docker-php-ext-install xml dom

#RUN printf "\n" | pecl install imagick
#RUN docker-php-ext-enable imagick

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

RUN touch $PHP_INI_DIR/conf.d/uploads.ini \
    && echo "upload_max_filesize = 50M;" >> $PHP_INI_DIR/conf.d/uploads.ini

WORKDIR /var/www

USER $user