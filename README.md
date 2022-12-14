#A Blog CRUD Single Page Application based on Laravel and Vue
Laravel Version : 8 | Vue.js Version 2


#Usage
To get started, clone the git repository to a particular folder  
     `git clone https://github.com/akramwahid/blogapp`

navigate to the directory where you cloned the project, you will find the following structure

    `README.md` : This is manual giving instruction on how to setup the project

    `docker-compose.yml`: docker related file that needed to setup our development environment

    `/src`  : this is where project source code resides


The cloned folder includes docker container files and project source code, so you don't need to
move the source code to your own web server. But if you want to test the source code
in your own web server for any reason, please copy the source code from `/src` folder
to your web server directory. 

    *** As this is a laravel project, Please make sure the site root is pointing to `/public` folder in the 
    source code if you are running it in your own web server.***

---
#1 __Spin up docker container__

make sure you have Docker System (Docker desktop for mac/windows) installed on your system.

in your terminal navigate to the directory where you cloned the project, and spin up the containers for nginx, php, mysql 
by running 

`docker-compose up -d --build app`. 

By default the mysql will run in port 3306, if you need to adjust the port or container names incase of conflicts, 
you can do it in `docker-compose.yml` file.


---


#2 __Install the Laravel Project__

 proceed and type the following commands in your terminal to install the project.

`docker-compose run --rm composer install`

---
  
#3 __Adjust Database Configuration__

make a copy of `.env.example` placed in the source code root `/src` and name it as `.env`.


By default the database configuration values in `.env.example` file are set to match the mysql containers default
values so you don't need to anything further.


    it is not a best practise to commit senstive info in source version control. However i am doing it purposely to make it easy to run the project.


---

#4 __Running Database migration and seeding test data__

next run the following artisan command in terminal to setup the database tables

`docker-compose run --rm artisan migrate`

next run the following command to seed some test data in to the database (authors, posts, comments)

`docker-compose run --rm artisan db:seed`


*** if you want to rebuild database tables and seed fresh data, you can do it with 

`docker-compose run --rm artisan migrate:fresh --seed` ***



---

#5 __Create a symbolic link__

run the following command To make the uploaded posts image files accessible from the web,
Following command will create a symbolic link from `public/storage` to `storage/app/public`
 
 `docker-compose run --rm artisan storage:link`
 

---

#6 __View the project in browser__

you can access the project in the url of `http://localhost:8087`

you can access the phpmyadmin database client in `http://localhost:8088`


#7 __Compiling frontend assets (Optional)__

This step is only required if you do any changes to the frontend code files, otherwise skip this section because I have 
made a production build of the frontend already

if you want rebuild frontend assets, you may run the following command to install npm modules

`docker-compose run --rm npm install`

and the run the following command to build the frontend in development environment 

`docker-compose run --rm npm run dev`


---

#8 __Testing with PHPUnit (Optional)__

I have added some test cases in the `/src/tests` directory 
To run the tests cases, execute following command

`docker-compose run --rm artisan test`

---

