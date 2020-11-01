phony: local

local:
	$(MAKE) down
	rm -rf postgresql
	mkdir -p postgresql/data
	rm -rf php/vendor
	docker-compose build
	docker-compose run php composer install
	docker-compose run php bin/console doctrine:database:create
	docker-compose run php bin/console doctrine:schema:create

up:
	docker-compose up -d

down:
	docker-compose down

restart:
	$(MAKE) down
	$(MAKE) up