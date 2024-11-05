#!/bin/bash
set -e

echo "Deployment started ..."
git pull origin development
php -r "file_exists('.env') || copy('.env.example', '.env');"
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
php artisan key:generate
php artisan migrate --seed
php artisan cache:clear
php artisan config:clear
php artisan storage:link
php artisan optimize
chown -R deployer:www-data /var/www/posporasi
find /var/www/posporasi -type f -exec chmod 664 {} \;
find /var/www/posporasi -type d -exec chmod 775 {} \;
chgrp -R www-data storage bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache
php artisan queue:restart
echo "Deployment finished!"
