#!/bin/bash

echo "🚀 Setting up IT Management System with Docker..."

# Copy environment file
if [ ! -f .env ]; then
    cp .env.docker .env
    echo "✅ Environment file created"
fi

# Build and start containers
echo "🔨 Building Docker containers..."
docker-compose up -d --build

# Wait for containers to be ready
echo "⏳ Waiting for containers to start..."
sleep 10

# Generate application key
echo "🔑 Generating application key..."
docker-compose exec app php artisan key:generate

# Run migrations and seeders
echo "📊 Running database migrations..."
docker-compose exec app php artisan migrate --force

echo "🌱 Running database seeders..."
docker-compose exec app php artisan db:seed --force

# Clear caches
echo "🧹 Clearing caches..."
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan view:clear

# Set permissions
echo "🔐 Setting permissions..."
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chown -R www-data:www-data /var/www/html/bootstrap/cache

echo "✅ Setup completed!"
echo ""
echo "🌐 Your application is now running at: http://localhost:8000"
echo "🗄️  phpMyAdmin is available at: http://localhost:8080"
echo ""
echo "📋 Useful commands:"
echo "   docker-compose up -d          # Start containers"
echo "   docker-compose down           # Stop containers"
echo "   docker-compose logs app       # View app logs"
echo "   docker-compose exec app bash  # Access app container"
