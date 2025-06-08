.PHONY: help build up down restart logs shell migrate seed fresh install

help: ## Show this help message
    @echo 'Usage: make [target]'
    @echo ''
    @echo 'Targets:'
    @awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  %-15s %s\n", $$1, $$2}' $(MAKEFILE_LIST)

build: ## Build Docker containers
    docker-compose build --no-cache

up: ## Start containers
    docker-compose up -d

down: ## Stop containers
    docker-compose down

restart: ## Restart containers
    docker-compose restart

logs: ## Show application logs
    docker-compose logs -f app

shell: ## Access application container shell
    docker-compose exec app bash

migrate: ## Run database migrations
    docker-compose exec app php artisan migrate

seed: ## Run database seeders
    docker-compose exec app php artisan db:seed

fresh: ## Fresh migration with seed
    docker-compose exec app php artisan migrate:fresh --seed

install: ## Initial setup
    @chmod +x docker/setup.sh
    @./docker/setup.sh

clear: ## Clear all caches
    docker-compose exec app php artisan config:clear
    docker-compose exec app php artisan cache:clear
    docker-compose exec app php artisan view:clear

composer-install: ## Install composer dependencies
    docker-compose exec app composer install

npm-install: ## Install npm dependencies
    docker-compose exec app npm install

npm-build: ## Build frontend assets
    docker-compose exec app npm run build
