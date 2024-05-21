## Developer Testing Project

The goal of this project is to create a "Task Manager" web application with Vue.js and Laravel as the backend API.

### Requirements

- [x] User should be able to view a list of tasks in a table (display task name, description, and status).
- [x] User should be able to click on a task to view more information about it (additional info such as task deadline, priority, etc.) on a modal in the same page.
- [x] User should be able to "take on" a task by clicking an action button in the table row. This should update the task's status to "In Progress".
- [x] User should be able to update a task's information and status ("In Progress", "Completed", etc.).
- [x] User should be able to mark a task as "Complete" with an action button on the task view.

### Specifics

- Implement the front-end using Vue.js. You can use other libraries or frameworks (like - Bootstrap or Tailwind CSS) for styling, but the interactive elements should primarily be implemented with Vue.js.
- Implement the back-end API using Laravel. The API should support operations to create, read, update, and delete (CRUD) tasks.
- For the purpose of this project, you can use a local SQLite database, or another database of your choice. You should use Laravel's Eloquent ORM for database operations.
- You can use dummy data for the task list.
- The project should include error handling. For example, it should handle the case where a request to the Laravel API fails.
- Include instructions on how to set up and run your project.

### Using this project

If you'd like to use this as the starting point, you can remove the boilerplate and install what you need. The focus should remain on the front-end task. You can also check Laravel Documentation on [how to get starte with Laravel](https://laravel.com/docs/10.x/installation)

Use the same project but addionatly with the following features:
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

### What We're Looking For

- Code quality: Your code should be well-organized and readable, with comments where necessary.
- Understanding of Vue.js: You should use Vue.js features effectively, including components, directives, and props.
- Understanding of asynchronous JavaScript: You should use async/await, promises, or callbacks appropriately to handle asynchronous operations, like requests to the Laravel API.
- Error handling: Your application should handle potential errors gracefully.
- User experience: The application should be easy to use and navigate.

### Submission

Please submit a link to a GitHub repository containing your project. The repository should include all code for the project, as well as a README with setup and run instructions.
