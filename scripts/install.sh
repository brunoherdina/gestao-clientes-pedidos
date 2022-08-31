docker-compose up -d
docker exec -d brudam-app composer update
docker exec -d brudam-app php artisan key:generate
docker exec -d brudam-app php artisan serve