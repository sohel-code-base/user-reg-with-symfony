# User Registration with Symfony Framework

## Setup guide

* clone the repo
* copy `.env.dist` file to `.env` and update database credentials
* run `composer install`
* run `php bin/console doctrine:database:create`. This command will create a database.
* run `php bin/console doctrine:migrations:migrate`
* run `npm install`
* run `npm run dev`
* install [symfony cli]('https://symfony.com/download')
* run `symfony server:start` to run the project