docker-compose up -d
docker exec -d brudam-app composer update
docker exec -d brudam-app php artisan key:generate
docker exec -d brudam-app php artisan migrate
docker exec -d brudam-app php artisan db:seed
docker exec -d brudam-app php artisan serve
docker exec -d brudam-app bash ./entrypoint.sh