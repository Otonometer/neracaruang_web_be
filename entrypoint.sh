#!/usr/bin/env bash

set -e

role=${CONTAINER_MODE:-app}
env=${APP_ENV:-production}

# if [ "$env" != "local" ]; then
#     echo "Caching configuration..."
#     (php artisan config:cache && php artisan route:cache && php artisan view:cache)
# fi

if [ "$role" = "app" ]; then
    mkdir -p storage/framework/{sessions,views,cache} || true
    chmod -R 777 storage
    php artisan cache:clear
    php artisan config:clear
    php artisan view:clear
    exec apache2-foreground

elif [ "$role" = "broker" ]; then
    php artisan bdi:broker:consume

elif [ "$role" = "scheduler" ]; then
    # while [ true ]
    # do
    #   php artisan schedule:run --verbose --no-interaction &
    #   sleep 60
    # done
    php artisan schedule:work

else
    echo "Could not match the container role \"$role\""
    exit 1
fi
