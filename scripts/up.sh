docker-compose up -d
docker exec -d brudam-app php artisan serve
docker exec -d brudam-app bash ./entrypoint.sh