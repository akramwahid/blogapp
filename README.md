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

in your terminal navigate to the directory where you cloned the project, and spin up the containers for nginx,php,mysql 
by running `docker-compose up -d --build app`. This will run all necessary containers to run the project.
By default the mysql will run in port 3306, if you need to adjust the port or container namees, 
you can do it in `docker-compose.yml` file.




