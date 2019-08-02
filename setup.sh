#!/usr/bin/env bash
docker-compose exec app cp ./.env.example ./.env

docker-compose exec app composer install

docker-compose exec app npm install

docker-compose exec app php artisan key:generate

docker-compose exec app php artisan migrate

docker-compose exec app npm run dev

docker-compose exec app touch database/test.sqlite

docker-compose exec app php artisan migrate --env=testing
