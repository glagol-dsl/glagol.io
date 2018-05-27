FROM php:7.2-apache

RUN apt-get update -y \
    && apt-get install -y --no-install-recommends \
        $PHPIZE_DEPS \
        zlib1g-dev \
        libsodium-dev \
    && pecl install libsodium mcrypt xdebug \
    && docker-php-ext-install pdo pdo_mysql mbstring zip \
    && docker-php-source delete \
    && rm -rf /tmp/pear ~/.pearrc \
    && apt-get purge -y $PHPIZE_DEPS \
    && apt-get autoremove -y \
    && rm -r /var/lib/apt/lists/* \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer \
    && composer global require "hirak/prestissimo:^0.3" \
    && a2enmod rewrite

COPY virtual_host.conf /etc/apache2/sites-available/000-default.conf
COPY app /var/www/html
COPY start.sh /usr/local/bin/start

RUN composer install --no-interaction \
    --no-progress \
    --no-scripts \
    --no-suggest \
    --no-dev \
    --prefer-dist

ENTRYPOINT ["start"]
