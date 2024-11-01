

start: ## Run the project
	docker-compose up -d
	symfony serve -d

stop: ## Stop the project
	symfony server:stop
	docker-compose down

fixtures:
	symfony console doctrine:fixtures:load

database-reset:
	symfony console doctrine:database:drop --force
	symfony console doctrine:database:create
	symfony console doctrine:migrations:migrate
	symfony console doctrine:fixtures:load
