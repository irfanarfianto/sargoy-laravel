# Sargoy Laravel Project

## Description

This project is a Laravel-based web application named Sargoy. It includes various functionalities typical of a Laravel application such as user authentication, CRUD operations, and integration with external services like Firebase.

## Features

-   User Authentication
-   CRUD operations for various entities (Products, Categories, etc.)
-   Firebase Integration
-   Tailwind CSS for styling
-   PHPUnit for testing

## Installation

### Prerequisites

-   PHP >= 8.0
-   Composer
-   Node.js & NPM
-   MySQL or any other supported database

### Steps

1. Clone the repository:

    ```sh
    git clone https://github.com/irfanarfianto/sargoy-laravel.git

    cd sargoy-laravel
    ```

2. Copy the `.env.example` to `.env` and configure the environment variables:

    ```sh
    cp .env.example .env
    ```

3. Install the PHP dependencies:

    ```sh
    composer install
    ```

4. Generate the application key:

    ```sh
    php artisan key:generate
    ```

5. Install the Node.js dependencies:

    ```sh
    npm install
    ```

6. Compile the assets:

    ```sh
    npm run dev
    ```

7. Run the database migrations:

    ```sh
    php artisan migrate
    ```

8. Seed the database:
    ```sh
    php artisan db:seed
    ```

## Usage

### Running the Application

You can start the local development server using:

```sh
php artisan serve
```

The application will be available at `http://localhost:8000`.

### Running Tests

To run the tests, use:

```sh
php artisan test
```

## Directory Structure

-   `app/Http/Controllers/`: Contains the controller classes.
-   `resources/views/`: Contains the Blade templates.
-   `routes/`: Contains all the route definitions.
-   `storage/`: Contains the application storage files.
-   `tests/`: Contains the test classes.

## License

This project is licensed under the MIT License.
