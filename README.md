# Dashboard
A simple company and employemnt management tool built using a Laravel API & a Vue3 frontend, with a MySql database. It takes advantage of user roles, where there is an admin user, and a regular user. An admin user can do the following:
 - Create new companies & update existing companies
 - Manage employees for those companies (employees have CRUD function implemented)

This was built using the [SkeletonBase](https://github.com/lazy-snorlax/SkeletonBase) project as an initial starting point, which speed up initial development time.

## Getting Started
TO start the application you will need to use [Docker Compose](https://docs.docker.com/compose/).
```bash
docker compose up --build
```
This will bring the following containers up.

| Name             | Ports (host:container) | Description                                        |
| ---------------- | ---------------------- | -------------------------------------------------- |
| mysql            | 33061:3306             | Main MySQL container                               |
| testing          | 33062:3306             | Testing MySQL container                            |
| mail             | 8025:80                | Mail interception container                        |
| api              | 8000:80                | Nginx container for the application                |
| fpm              |                        | FPM container for the application                  |
| vue              | 8080:8080              | Vue container for the application                  |

Once the containers are up you will need to create the `.env` file for the API application.

You can copy the `api/.env.example` file. Make sure if you're using your local IP address for development that you update the relevant URLs within these files, including the Sanctum stateful domains.

You should also create local development environment files for the Vue application. You can copy the `vue/.env.development` file making sure you update any relevant URLs.

### Install Composer Dependencies
You can install Composer dependencies by running the `composer install` command on the FPM container.

```bash
docker compose exec fpm composer install
```

To install a new dependency you can use the `composer require` command.

```bash
docker compose exec fpm composer require new-dependency
```

### Install NPM Depdendencies
You can install NPM dependencies by running the `npm install` command on the Vue container.

```bash
docker compose exec vue npm install
```

To install a new dependency you can use the `npm install` command.

```bash
docker compose exec vue npm install new-dependency
```

### Command to generate application key
```bash
docker compose exec fpm php artisan key:generate
```

### Command to run Database Seeder
```bash
docker compose exec fpm php artisan migrate:fresh --seed
```

### Command to run PHPUnit tests
```bash
docker compose exec fpm ./vendor/bin/phpunit
```