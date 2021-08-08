Virtual Bank Account
==========

Sample project.  
See [GitHub Projects](https://github.com/KatoPue/virtual-bank-account/projects) for notes and thoughts.

Getting Started
---------------

These instructions will get you a copy of the project up and running in your development and production environments.

### Prerequisites

What tools you need to install and run the project:
- docker

### Development environment

To run everything locally, without a proxy like traefik to forward the request to the correct docker container, you will need to bind the webserver to a local port.   
For that create a `docker-compose.override.yml` in the project root.

The test environment is configured to use a sqlite database. Some php extensions are needed to work with sqlite.

Example configuration:
```
version: '3'

services:
  php:
    environment:
      - PHP_EXTENSION_XDEBUG=1

  nginx:
    ports:
      - "8000:80"

  phpmyadmin:
    image: phpmyadmin
    ports:
      - "8080:80"
    environment:
      - PMA_ARBITRARY=1
```

### installing dependencies via composer

Run the following commands in the project directory

```
$ docker-compose up -d
$ docker-compose exec php composer install
```

### Create and update the database

Create and Update the database to match the current schema

```
$ docker-compose exec php bin/console doctrine:migrations:migrate -n
```

### Recreate/reset the database

```
$ docker-compose exec php bin/console doctrine:database:drop --force
$ docker-compose exec php bin/console doctrine:database:create
$ docker-compose exec php bin/console doctrine:migrations:migrate -n
```

### Load fixtures

```
$ docker-compose exec php bin/console doctrine:fixtures:load
```

### testing

```
$ docker-compose exec php vendor/bin/phpunit
```

Troubleshooting
---------------

### docker

Omit `-d` from `docker-compose up -d` to see logs directly in your shell. That makes troubleshooting easier.
```
$ docker-compose up
```

### permissions

To run the symfony console you now need to make it executable
```
$ docker-compose exec php chmod +x bin/console
```

To run phpunit you need to make it executable
```
$ docker-compose exec php chmod +x bin/phpunit
```

### database was not created

Create the database
```
$ docker-compose exec php bin/console doctrine:database:create
```
