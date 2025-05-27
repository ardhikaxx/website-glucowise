#!/bin/bash

echo "Running deploy script"

echo "[1/7] Pulling from GitHub"
git pull origin

echo "[2/7] Ensuring correct database host configuration"
# Check that DB_HOST in .env matches the actual MySQL container name if using Docker
# Example: DB_HOST=laravel_db (This should match your MySQL container name)
sed -i 's/DB_HOST=127.0.0.1/DB_HOST=laravel_db/g' .env

echo "[3/7] Creating database if one isn't found"
touch database/database.sqlite

echo "[4/7] Installing packages using composer"
composer install

echo "[5/7] Generate Key for encryption"
php artisan key:generate

echo "[6/7] Running tests"
docker exec laravel_app1 php artisan test

echo "[7/7] Running migrations and seeds"
docker exec laravel_app1 php artisan migrate:fresh --seed

echo "The app has been built and deployed!"