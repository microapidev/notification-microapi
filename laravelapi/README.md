# Notification Micro-API

## How to Setup

<code>cd laravelapi</code>

copy .env.example to .env

<code>composer install</code>

<code>php artisan key:generate</code>

<code>php artisan migrate</code>

<code>php artisan serve<code>


# Working End Points

### User Endpoints

POST http://127.0.0.1:8000/api/user/new // creates a new user with params "email" and "recovery_password"

GET http://127.0.0.1:8000/api/user/retrieve/:email/:recovery_password // get details about an email

### Notification Endoints
POST http://127.0.0.1:8000/api/notification/new // creates a notification with params "title", "icon", "body", "email"

GET http://127.0.0.1:8000/api/notification/retrieve/:email // retrieve all notifications by a user

PUT http://127.0.0.1:8000/api/notification/update/:notification_unique_id // updates a notification with params "title", "icon", "body" and "email"
