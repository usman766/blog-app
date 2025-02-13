# Blog API

## Overview
This is a Laravel-based Blog API that allows users to create, update, delete, and manage blog posts. The API uses password-based authentication and follows RESTful principles.

## Features
- User authentication using password-based authentication.
- Create, update, and delete blog posts.
- Soft delete and restore blogs.
- Retrieve a list of blogs with pagination.

## Installation

1. Clone the repository:
   ```sh
   git clone https://github.com/your-repo.git
   cd your-repo
   ```

2. Install dependencies:
   ```sh
   composer install
   ```

3. Copy the `.env.example` file to `.env` and configure your database settings:
   ```sh
   cp .env.example .env
   ```

4. Generate an application key:
   ```sh
   php artisan key:generate
   ```

5. Run migrations:
   ```sh
   php artisan migrate --seed
   ```

6. Start the development server:
   ```sh
   php artisan serve
   ```

## API Endpoints

### Authentication
- `POST /api/login` - Authenticate and get a token.
- `POST /api/register` - Register a new user.
- `POST /api/logout` - Logout from the system.

### Blog Endpoints
- `GET /api/blogs` - Retrieve a list of blogs.
- `POST /api/blogs` - Create a new blog.
- `GET /api/blogs/{id}` - Retrieve a single blog.
- `PUT /api/blogs/{id}` - Update an existing blog.
- `DELETE /api/blogs/{id}` - Soft delete a blog.
- `DELETE /api/blogs/{id}/force` - Permanently delete a blog.
- `POST /api/blogs/{id}/restore` - Restore a deleted blog.

## Running Tests
To run unit tests:
```sh
php artisan test
```

## Postman Collection
You can import the provided Postman collection to test the API endpoints.

[Download Postman Collection](./postman_collection.json)

## License
This project is open-source and free to use.

