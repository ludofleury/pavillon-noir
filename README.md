# :pirate_flag: Black Flag

![Build Status](https://github.com/ludofleury/pavillon-noir/workflows/ci/badge.svg?branch=master) [![codecov](https://codecov.io/gh/ludofleury/pavillon-noir/branch/master/graph/badge.svg)](https://codecov.io/gh/ludofleury/pavillon-noir)

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

1. build docker images, install deps & initialize the stack

```
  make local
```

2. run the stack

```
  make up
```

## Development

### Dependency & boostrap management with composer

1. run your docker-compose stack

```
make up
```

2. run the following commands

```
docker-compose exec php composer 
docker-compose exec php composer install
docker-compose exec php composer require xxx/yyyy
```

### Testing with PHP Unit

1. run your docker-compose stack

```
make up
```

2. run the following commands

```
make test
```

or

```
docker-compose exec php vendor/bin/phpunit --testdox
```


### Specification process

Event storming available on [gdrive](https://docs.google.com/document/d/1Ne8oRaANIvFzSDxvzlruglWoT8TnyzkJl6xL3PJRFkA/edit)
