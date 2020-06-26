## Setup

cd laravelapi

php artisan key:generate

php artisan serve

make sure you edit your .env file with your database name, username, and password

<code>php artisan migrate</code>



## End Points

GET http://127.0.0.1:8000/api/notifications  //get all notifications

POST http://127.0.0.1:8000/api/notifications //create a notification

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
