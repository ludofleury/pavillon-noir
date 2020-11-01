# Black Flag

PHP application designed to assist role-playing game session for the "Pavillon Noir" game.

Showcasing usage of:

  - Domain Driven Design
  - CQRS
  - Event Sourcing


## Setup

### Requirements

- docker
- docker-compose

### Bootstrap 

1. build docker images & install deps

```
  make local
```

2. run the stack

```
  make up
```

## Development

### Dependency & boostrap management with composer

From your host, without the docker-compose stack being up

```
docker-compose run php composer 
docker-compose run php composer install
docker-compose run php composer require xxx/yyyy
```

or from your host, with the docker-compose stack already up

```
docker-compose exec php composer 
docker-compose exec php composer install
docker-compose exec php composer require xxx/yyyy
```

### Testing with PHP Unit

From your host, without the docker-compose stack being up

```
docker-compose run php vendor/bin/phpunit  --testdox
```

From your host, with the docker-compose stack already up

```
docker-compose exec php vendor/bin/phpunit --testdox
```