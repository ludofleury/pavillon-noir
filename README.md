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

PHP composer dependency management is available

```
docker-compose run php composer 
docker-compose run php composer install
docker-compose run php composer require xxx/yyyy
```
