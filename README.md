# Translation Service

This Laravel module provides an API for managing translations, including support for multiple locales and tagging.
It includes functionality for listing, creating, updating, and deleting translations, with optional filtering by key and tags.

---

## Features
- **List translations** by locale, with optional filtering by key and tags.
- **Tag-based grouping** — translations can be accessed as `tag.key` if tagged.
- **CRUD operations** for translations.

---

## Setup Instructions

### 1. Clone the repository
```bash
git clone https://github.com/jeddsaliba/laravel-translation-service.git
cd laravel-translation-service
```

### 2. Install the `dependencies` by running the following command:
```bash
composer install
npm install
```

### 3. Generate a new `.env` file by running:
```bash
cp .env.example .env
```

### 4. Configure the `APP_URL` in your `.env` file:
```bash
APP_URL=http://localhost
```

### 5. Configure the `MySQL` connection in your `.env` file:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

or if you're using `PostgreSQL`:
```bash
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

### 6. Assuming that you have already created an empty database, run this command to migrate the database tables:
```bash
php artisan migrate
```

### 7. You may also run this command in order to populate the database with test data:
```bash
php artisan db:seed
```

### 8. Integrate Postman for handling APIs.

[Here](https://github.com/jeddsaliba/laravel-translation-service/docs/postman/Laravel_Translation_Service_API.postman_collection.json) is the [postman](https://www.postman.com) collection. Just import it and you're all set!

### 9. When logging in, you may use the following credentials:
```bash
Email: admin@admin.com
Password: password
```
