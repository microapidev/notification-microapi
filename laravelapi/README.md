## Setup

<code>cd laravelapi</code>

<code>composer install</code>

<code>php artisan key:generate</code>

<code>php artisan serve</code>

make sure you edit your .env file with your database name, username, and password

<code>php artisan migrate</code>



## End Points

GET http://127.0.0.1:8000/api/notifications   <!--Get all notifications -->

GET http://127.0.0.1:8000/api/notifications/{id}   <!--Get a single notifications -->

POST http://127.0.0.1:8000/api/notifications  <!-- Create a notification -->

PUT http://127.0.0.1:8000/api/notifications/{id}   <!--Update a single notifications -->

DELETE http://127.0.0.1:8000/api/notifications/{id}   <!--Delete a single notifications -->


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
