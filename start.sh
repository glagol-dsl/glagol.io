#!/usr/bin/env sh

if [ $1 = "--dev" ]; then
    composer install --no-interaction \
        --no-progress \
        --no-scripts \
        --no-suggest \
        --prefer-dist \
    && echo 'zend_extension=xdebug.so' > /usr/local/etc/php/conf.d/xdebug.ini
fi

php artisan passport:keys -q \
&& apache2-foreground
