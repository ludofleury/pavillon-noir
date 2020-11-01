phony: local

local:
	rm -rf postgresql
	mkdir -p postgresql/data
	rm -rf php/vendor
	docker-compose run php composer install
	docker-compose run php bin/console doctrine:database:create
	docker-compose run php bin/console doctrine:schema:create

up:
	docker-compose up -d

down:
	docker-compose down