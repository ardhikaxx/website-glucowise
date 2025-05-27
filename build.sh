#!/bin/bash

echo "Running deploy script"

echo "[1/6] Pulling from GitHub"
git pull origin

echo "[2/6] Ensuring correct database host configuration"
# Check that DB_HOST in .env matches the actual MySQL container name if using Docker
# Example: DB_HOST=laravel_db (This should match your MySQL container name)
sed -i 's/DB_HOST=127.0.0.1/DB_HOST=laravel_db/g' .env

echo "[3/6] Creating database if one isn't found"
touch database/database.sqlite

echo "[4/6] Installing packages using composer"
composer install

# echo "[5/6] Publishing API Platform assets"
# php artisan api-platform:install

echo "[5/6] Generate Key for encryption"
php artisan key:generate

echo "[6/6] Login"
docker exec -it laravel_app1 bash

echo "[7/7] Running fresh migrations and seeding"
php artisan migrate:fresh --seed

echo "The app has been built and deployed!"