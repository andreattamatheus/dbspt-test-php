## Developer Testing Project

Project Teste for DBServices

"Task Manager" project developed with Vue.js and Laravel as the backend API.

### Requirements

- [x] User should be able to view a list of tasks in a table (display task name, description, and status).
- [x] User should be able to click on a task to view more information about it (additional info such as task deadline, priority, etc.) on a modal in the same page.
- [x] User should be able to "take on" a task by clicking an action button in the table row. This should update the task's status to "In Progress".
- [x] User should be able to update a task's information and status ("In Progress", "Completed", etc.).
- [x] User should be able to mark a task as "Complete" with an action button on the task view.
- [x] Implement the back-end API using Laravel. The API should support operations to create, read, update, and delete (CRUD) tasks.
- [x] Dummy data for the task list.

### Using this project

If you'd like to use this as the starting point, you can remove the boilerplate and install what you need. The focus should remain on the front-end task. You can also check Laravel Documentation on [how to get starte with Laravel](https://laravel.com/docs/10.x/installation)

Use the same project but additionally with the following features:
To use this project you can clone this repo and start the application setup, make sure you have `PHP/composer` and `Docker` installed:

- Save the file `.env.example` as `.env`
- I had to add in `.env`:
  - `SESSION_DOMAIN=".localhost"`
  - `SANCTUM_STATEFUL_DOMAINS="localhost,localhost:8080"`
- Run `composer install` To install dependencies
- Bring the laravel sail containers up with `./vendor/bin/sail up -d`
- Run `./vendor/bin/sail npm install` To use the npm from the default docker provided by Laravel Sail
- Run `./vendor/bin/sail artisan migrate` To initialize the sqlite database (it should create database/database.sqlite file)
- Run `./vendor/bin/sail artisan db:seed` To generate the fake data
- Run `./vendor/bin/sail npm run build` To build and to watch for changes replace `build` with `dev`
- Go to http://localhost:8080 and register an account, on the dashboard page you can work on the task
- Or you can use the default data: Email = 'teste@gmail.com' and Password = '123123123'

![Preview](./preview.png?raw=true "Dashboard Preview")
