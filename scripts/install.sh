docker-compose up -d
docker exec -it brudam-app composer update
docker exec -it brudam-app php artisan key:generate
docker exec -it brudam-app php artisan migrate
docker exec -it brudam-app php artisan db:seed
docker exec -d brudam-app bash ./entrypoint.sh
docker exec -it brudam-app php artisan serve