# Finance App - Code Sample

This application demo was built for the purpose of providing code samples.  It was built using the [Laravel](https://laravel.com) and [Vue.js](https://vuejs.org) frameworks.

It's a single-page app that displays transactions from a fictitious bank account.  You can add new transactions and edit existing transactions, and the page will update automatically.

You can bring the application up using Docker.  (You will first have to install Docker on your system.  Refer to their website for details: [https://www.docker.com](https://www.docker.com)).  After it's installed you need to do the following:

 - Clone this repository.
 - Open a command prompt and navigate to the directory where you cloned
   the repository.
 - Run the following command to build and start the Docker containers (PHP, MySQL, NGINX, and phpMyAdmin):  `docker-compose up -d`
 - Once they are running you can connect to the PHP container using the following command: `docker exec -ti finance-app-demo_finance_core_1 /bin/bash`
 - **NOTE:** The container name may differ depending on your system(e.g. finance-app-demo_finance_core_1).  Which may mean the previous command failed.  Run `docker ps` to see a listing of running containers and obtain the correct name.  You can then re-run the previous command with the correct name.

Once connected to the PHP container(or other system if you're not using Docker), you can then run the following commands:

 - Run the migrations: `php artisan migrate`
 - **Optional Step:**  I set up a database seeder to initially add hundreds of random transactions for demo purposes.  The command to run the seeder is as follows: `php artisan db:seed --class=DemoSeeder`

If you have run the seeder then there is also a demo account with the following credentials:

> username:  molly@example.com
> 
> password:  password

If you're running the Docker containers then you should be able to access the site in your browser at [http://localhost](http://localhost).

If you would like to look at the database directly, you can do so via the phpMyAdmin container.  It is running at [http://localhost:8080](http://localhost:8080) and has the following credentials:

> username:  root
> 
> password:  badpassword
