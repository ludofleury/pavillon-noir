phony: help

default: help

help: ## Show this help.
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m\033[0m\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)


local: ## Install (or reset) & bootstrap local environment
	$(MAKE) down
	rm -rf postgresql
	mkdir -p postgresql/data
	rm -rf php/vendor
	docker-compose build
	$(MAKE) up
	docker-compose exec php composer install
	docker-compose exec php bin/console doctrine:database:create
	docker-compose exec php bin/console doctrine:schema:create
	$(MAKE) down

up: ## start the local environement
	docker-compose up -d

down: ## stop the local environement
	docker-compose down

restart: ## restart local environement
	$(MAKE) down
	$(MAKE) up

test: ## launch test suite & write report in php/reports/
	docker-compose exec php vendor/bin/phpunit --testdox

