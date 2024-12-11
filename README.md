# Content Management API

This project is a simple API for managing content such as posts, tags, and statistics. It allows authenticated users to perform CRUD operations on posts, retrieve all available tags, and view analytics related to posts.

## Features

- **Post Management**: Allows users to create, read, update, and delete posts.
- **Tag Management**: Users can view all tags associated with posts.
- **Statistics**: Provides basic analytics related to posts, such as views, comments, etc.
- **Authentication**: Only authenticated users can access the API.

## Technologies Used

- **Laravel**: Backend framework for API development.
- **MySQL**: Database used for storing data.
- **JWT Authentication**: For securing API routes and user authentication.

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/project-name.git
   cd project-name
2. Install dependencies:
```bash
composer install
```

3. Set up the environment variables: Rename .env.example to .env and configure your database and other environment settings.

4. Generate the application key:
```bash
php artisan key:generate
```
5. Run migrations to set up the database:

```bash
php artisan migrate
```

6. Install Passport for authentication:
```
```bash
php artisan passport:install
```

7. Seed the database (optional, for test data):
```bash
php artisan db:seed
```
8. Start the server:
```bash
php artisan serve
```

# API Endpoints
**Auth Routes**
- **POST /api/login:** Logs in a user and returns a JWT token.
**Post Routes**

- **GET /api/posts:** Retrieves all posts.
- **POST /api/posts:** Creates a new post.
- **GET /api/posts/{id}:** Retrieves a specific post.
- **PUT /api/posts/{id}:** Updates a specific post.
- **DELETE /api/posts/{id}:** Deletes a specific post.
**Tag Routes**

- **GET /api/tags:** Retrieves all tags.
**Stats Routes**

- **GET /api/stats:** Retrieves statistics related to posts.

**Authentication**

To authenticate, you need to include the JWT token in the Authorization header as a Bearer token.

Example:
```bash
Authorization: Bearer YOUR_ACCESS_TOKEN
```


### Explanation of the **README**:

- **Installation**: Explains how to install and set up the project locally.
- **API Endpoints**: Lists all the API endpoints and their descriptions.
- **Authentication**: Explains how to use the token for authentication.
- **Contributing**: Outlines how to contribute to the project.
- **License**: Specifies the project license (MIT in this case).

### This Project Made By Ahmed Gamal  


