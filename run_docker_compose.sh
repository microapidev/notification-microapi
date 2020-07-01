#!/bin/bash

IMAGE_NAME=microapi

docker-compose up -d \
docker-compose ps \
docker-compose exec $IMAGE_NAME ls -l \
docker-compose exec $IMAGE_NAME composer install \
docker-compose exec $IMAGE_NAME php artisan key:generate
docker-compose logs nginx