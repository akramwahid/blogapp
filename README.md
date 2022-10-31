#A Blog CRUD Single Page Application based on Laravel and Vue
Laravel Version : 8 | Vue.js Version 2

#Usage
To get started, clone the git repository to a particular folder

The project source code will be commit with docker container setup to run it easy, so you don't
need to setup the source code in your own web server. But if you want to test the source code
in your own web server for any reason, please copy the source code from `/src` folder
to your web server directory. 

*** As this is a laravel project, Please make sure the site root is pointing to `/public` folder in the 
source code if you are running it in your own server.***

#Spin up docker container
make sure you have Docker System (Docker desktop for mac/windows) installed on your system.

in your terminal navigate to the directory where you cloned the project, and spin up the containers for nginx, php, mysql 
by running `docker-compose up -d --build app`. 
By default the mysql will run in port 3306, if you need to adjust the port or container names, 
you can do it in `docker-compose.yml` file.

*** If the previous step is successful, you can access the project in the url of `http://localhost:8087` ***

*** If the previous step is successful, you can access the phpmyadmin database client in `http://localhost:8088` ***

#Install Laravel Project
next proceed and type the following commands in terminal to install the laravel project dependencies.

`docker-compose run --rm composer install`

once the project is successfully installed, make a copy of `.env.example` placed in the project source code root `/src/`
and name it as `.env`.
  
#Adjust Database Configuration
By default the database configuration values in `.env.example` file are set to match the mysql containers default
values so the `.env` is, however it is not a best practise to commit senstive info in source version control.
However i am doing it purposely to make it easy to run the project.  

*** If you are running the project in your own server, you must adjust the database configurations in `.env` file. ***

#Running Database migration and seeding test data
then run the following artisan command in terminal to setup the database tables
`docker-compose run --rm artisan migrate`

next run the following command to seed some test data in to the database (authors, posts, comments)
`docker-compose run --rm artisan db:seed`

*** if you want to rebuild database tables and seed fresh data, you can do it with 
`docker-compose run --rm artisan migrate:fresh --seed` ***

#create a symbolic link to make uploaded files visible in web
next run the following command To make the uploaded posts image files accessible from the web,
Following command will create a symbolic link from `public/storage` to `storage/app/public`
 
`docker-compose run --rm artisan storage:link`

#compiling frontend assets
if you want rebuild frontend assets, you may run the following command to install npm modules
`docker-compose run --rm npm install`

and the run the following command to build the frontend
`docker-compose run --rm npm run dev`

#Testing with PHPUnit
I have added some test cases in the `tests` directory 
To run the tests cases, execute following command
`docker-compose run --rm artisan test`