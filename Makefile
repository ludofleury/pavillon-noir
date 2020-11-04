phony: local

local:
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

up:
	docker-compose up -d

down:
	docker-compose down

restart:
	$(MAKE) down
	$(MAKE) up