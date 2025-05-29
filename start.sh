#!/usr/bin/env bash

docker compose -f docker-compose-build.yml up -d --build
docker compose -f docker-compose-build.yml exec build-fpm composer install
docker compose -f docker-compose-build.yml exec build-fpm composer install --no-dev
docker compose -f docker-compose-build.yml exec build-vue npm run staging
docker compose -f docker-compose-build.yml stop

docker compose -f docker-compose-prod.yml build
docker compose -f docker-compose-prod.yml up -d

set -e
SERVICE_NAME=caremaster-test

# docker compose exec app-fpm php artisan migrate
echo "🔄 Running Laravel migrations..."
docker exec -it $SERVICE_NAME-app-fpm-1 php artisan migrate --force
echo "✅ Migrations complete."

echo "🧪 Running unit tests..."
if docker exec -it $SERVICE_NAME-app-fpm-1 ./vendor/bin/phpunit; then
    echo "✅ Tests passed successfully."
else
    echo "❌ Tests failed!"
    echo "🚫 Deployment aborted due to test failures."
    exit 1
fi