# steps
- clone project
- then run:
``
composer install
``
- run laravel sail to build project
``
./vendor/bin/sail up
``
- to run project run 
`` 
./vendor/bin/sail up -d
``
- to stop the project
`` 
./vendor/bin/sail down
``
- in .env file change APP_PORT to any port you need or copy .env.example to .env

- migrate the database
``
./vendor/bin/sail artisan migrate
``
- to run the command to connect with github run :
``
./vendor/bin/sail artisan update:top-repos
``
- if you want to open phpmyadmin , open it in port 8077
