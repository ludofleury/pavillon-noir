phony: local

local:
	rm -rf postgresql
	mkdir -p postgresql/data
	rm -rf php/vendor
	docker-compose run php composer install

up:
	docker-compose up -d

down:
	docker-compose down