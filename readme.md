This is for Social Data Applciation.

==============================================================================================================
Create a .env file at root directory and put the information like bellow. And change the information according. That means your will not be to change any files under app/config folder.

APP_ENV=local

APP_DEBUG=true

APP_KEY=fOrfwAOUtrp4j2A1ijZMjPSqynIaIQHD


DB_HOST=127.0.0.1

DB_DATABASE=socialdata

DB_USERNAME=root

DB_PASSWORD=root


CACHE_DRIVER=file

SESSION_DRIVER=file

QUEUE_DRIVER=sync


REDIS_HOST=127.0.0.1

REDIS_PASSWORD=null

REDIS_PORT=6379


MAIL_DRIVER=smtp

MAIL_HOST=mailtrap.io

MAIL_PORT=2525

MAIL_USERNAME=null

MAIL_PASSWORD=null

MAIL_ENCRYPTION=null

 
==================================================================

Laravel version is: 5.1

To setup this application to your environment, just clone this project and then run the command

composer update --no-scripts

composer dump-autoload -o


To get database run the migration command:

php artisan migrate --path="app/modules/user/database/migrations"

php artisan migrate --path="app/modules/socialdata/database/migrations"

Now browse to the public directory like http://localhost/socialdata/public

Default User : admin

Default Pass : admin



