# SkeletonBase
A full stack project skeleton built using MySQL and Laravel as a backend, with Vue 3 as a frontend. The purpose of this project is to use it as a template or base to build other projects.

## Build 2.0
### Front-End
Front end is Vue 3 with Pinia and Bootstrap. This can be substituted with TailwindCSS, or with React or Angular. Basically anything that is installable with NPM.

### Back-End
The backend is intended as a REST API. Currently PHP 8.3 and Laravel 12, can also be substituted with any other backend web technology (ASP.NET for instance)

### Database
MySQL is the default database for this project, but MSSQL, SQL Server and PostgreSQL can all be made to work in this environment.

### Web Server
Currently is an Nginx server

### Docker Containers
Everything has been containerized for local development environment. Make sure Docker is installed & run:
```
docker compose up --build
```

Once built successfully, you will need to run the package installers manually. this can be done either by running
```
docker compose exec <NAME_OF_SERVICE> <COMMAND_TO_EXEC>
```
or by bashing into the running service and running any instructions inside the container
```
docker compose exec <NAME_OF_SERVICE> bash
```


For more information on each service, check out the docker-compose.yml and Dockerfile file in each folder.
