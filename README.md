


## About Coaltion Technologies Example



## Setup
- Install composer `composer install`
- Generate .env file `cp .env.example .env`
- Start Laravel Sail `./vendor/bin/sail up --build`
- Generate application key `./vendor/bin/sail php artisan key:generate`
- Change `DB_HOST in .env from 127.0.0.1 to mysql`
- Migrate database tables `./vendor/bin/sail php artisan migrate`
- Seed the database `./vendor/bin/sail php artisan db:seed`
- Install NPM and Run the development server ` ./vendor/bin/sail npm install && npm run dev`
- Visit: `http:localhost`

