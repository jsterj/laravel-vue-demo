# Finance App Demo

This application demo is based on the trial project proposal provided by Delicious Brains Inc. It was built using the Laravel and Vue.js frameworks.  Refer to to the following repository for complete details about the proposal: [https://github.com/deliciousbrains/finance-app-trial-project](http://)

I used Docker containers as my development environment.  If you would like to spin it up using Docker then please refer to the following steps.  (You will first have to have Docker installed on your system.  Refer to their website for details: [https://www.docker.com/](https://www.docker.com/))

 - Open a command prompt and navigate to the directory where you cloned
   the repository.
 - Run the following command to build and start the Docker containers (PHP, MySQL, NGINX, and phpMyAdmin):  `docker-compose up -d`
 - Once they are running you can connect to the PHP container using the following command: `docker exec -ti finance-app-demo_finance_core_1 /bin/bash`
 - **NOTE:** The container name may differ depending on your system(e.g. finance-app-demo_finance_core_1).  Which may mean the previous command failed.  Run `docker ps` to see a listing of running containers and obtain the correct name.  You can then re-run the previous command with the correct name.

Once connected to the PHP container(or other system if you've chosen a different environment), you can then run the following commands.
 - Run the migrations: `php artisan migrate`
 - **Optional Step:**  I set up a database seeder to initially add hundreds of random transactions for demo purposes.  The command to run the seeder is as follows: `php artisan db:seed --class=DemoSeeder`

If you have run the seeder then there is also a demo user account with the following credentials:
username:  molly@example.com
password:  password

If you're running the Docker containers you should be able to access the site in your browser at "localhost".

The phpMyAdmin container is running at "localhost:8080" and has the following credentials:
username:  root
password:  badpassword
