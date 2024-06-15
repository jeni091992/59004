# ProspectPath Application README

## Introduction

Welcome to the ProspectPath Application! This README file provides an overview of the application, how to set it up, and instructions for use. 

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database Setup](#database-setup)
- [Running the Application](#running-the-application)
- [Testing](#testing)
- [Deployment](#deployment)
- [License](#license)

## Requirements

Before installing, ensure you have the following:

- PHP >= 8.1
- Composer
- MySQL or another supported database
- Node.js & npm (for frontend assets)
- Git (for version control)

## Installation

To get started with the Laravel application, follow these steps:

1. **Clone the repository:**
    ```bash
    git clone https://github.com/jeni091992/deals-app.git
    cd deals-app
    ```

2. **Install dependencies:**
    ```bash
    composer install
    npm install
    npm run dev
    ```

3. **Copy the example environment file and modify it:**
    ```bash
    cp .env.example .env
    ```

## Configuration

1. **Generate an application key:**
    ```bash
    php artisan key:generate
    ```

2. **Set up your `.env` file:**
    - Configure your database settings (DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD)
    - Configure other environment-specific settings as needed (e.g., MAIL settings, CACHE settings)

## Database Setup

1. **Run the database migrations:**
    ```bash
    php artisan migrate
    ```

2. **(Optional) Seed the database:**
    ```bash
    php artisan db:seed
    ```

## Running the Application

1. **Start the local development server:**
    ```bash
    php artisan serve
    ```

2. **Access the application in your web browser:**
    ```plaintext
    http://localhost:8000
    ```

## Testing

1. **Run the test suite:**
    ```bash
    php artisan test
    ```

2. **Running tests with coverage:**
    ```bash
    ./vendor/bin/phpunit --coverage-html coverage
    ```

## Deployment

When deploying the Laravel application to production, follow these steps:

1. **Ensure you have configured the production environment variables in the `.env` file.**

2. **Optimize the application:**
    ```bash
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```

3. **Set the correct permissions for storage and cache directories:**
    ```bash
    chown -R www-data:www-data storage
    chown -R www-data:www-data bootstrap/cache
    ```

4. **(Optional) Use a queue worker for handling jobs:**
    ```bash
    php artisan queue:work
    ```

## License

This application is open-source software licensed under the [MIT license](LICENSE).

---

Feel free to reach out to the project maintainers if you have any questions or need further assistance. 
