# Test Shop API

A RESTful API built with Laravel 12 for e-commerce functionality, featuring product management and shopping cart operations. This is a backend-only API that can be consumed by any frontend application or tested with tools like Postman.

## Features

-   **Product Management**: Full CRUD operations for products
-   **Shopping Cart**: Session-based shopping cart system (cookie-based for API)
-   **RESTful API**: Complete API endpoints for all operations
-   **CORS Enabled**: Ready for cross-origin requests from frontend applications

## Requirements

-   PHP >= 8.2
-   Composer
-   Node.js >= 18.x and npm
-   SQLite (included in the project)

## Installation

1. **Clone the repository**

    ```bash
    git clone <repository-url>
    cd testShop
    ```

2. **Install PHP dependencies**

    ```bash
    composer install
    ```

3. **Install Node.js dependencies**

    ```bash
    npm install
    ```

4. **Environment setup**

    Create a `.env` file if it doesn't exist, or Laravel will create one automatically. Then generate the application key:

    ```bash
    php artisan key:generate
    ```

5. **Database setup**

    ```bash
    php artisan migrate
    ```

6. **Build assets**
    ```bash
    npm run build
    ```

## Usage

### Development Server

Start the Laravel development server:

```bash
php artisan serve
```

The API will be available at `http://localhost:8000`

### Quick Setup Script

You can use the setup script to install dependencies and configure the project:

```bash
composer run setup
```

## API Endpoints

All API endpoints are prefixed with `/api`. The base URL is `http://localhost:8000/api` when running locally.

### Product Endpoints

| Method   | Endpoint             | Description            | Request Body                               |
| -------- | -------------------- | ---------------------- | ------------------------------------------ |
| `GET`    | `/api/products`      | Get all products       | -                                          |
| `POST`   | `/api/products`      | Create a new product   | `name`, `description`, `price`, `quantity` |
| `GET`    | `/api/products/{id}` | Get a specific product | -                                          |
| `PUT`    | `/api/products/{id}` | Update a product       | `name`, `description`, `price`, `quantity` |
| `DELETE` | `/api/products/{id}` | Delete a product       | -                                          |

### Cart Endpoints

| Method   | Endpoint         | Description              | Notes                      |
| -------- | ---------------- | ------------------------ | -------------------------- |
| `GET`    | `/api/cart`      | Get cart contents        | Returns JSON array         |
| `POST`   | `/api/cart/{id}` | Add product to cart      | Requires product ID in URL |
| `DELETE` | `/api/cart/{id}` | Remove product from cart | Requires product ID in URL |

**Note:** Cart operations use session-based storage. When testing with Postman, make sure to enable cookies in your requests to maintain the session.

## Testing with Postman

### Setup

1. **Base URL**: Set your base URL to `http://localhost:8000/api`
2. **Enable Cookies**: In Postman settings, enable "Send cookies" to maintain session for cart operations
3. **Headers**: Set `Content-Type: application/json` for POST/PUT requests
4. **Accept**: Set `Accept: application/json` header

### Example Requests

#### Create a Product

```http
POST http://localhost:8000/api/products
Content-Type: application/json
Accept: application/json

{
    "name": "Test Product",
    "description": "This is a test product",
    "price": 29.99,
    "quantity": 100
}
```

#### Get All Products

```http
GET http://localhost:8000/api/products
Accept: application/json
```

#### Add Product to Cart

```http
POST http://localhost:8000/api/cart/1
Accept: application/json
```

#### Get Cart Contents

```http
GET http://localhost:8000/api/cart
Accept: application/json
```

#### Update a Product

```http
PUT http://localhost:8000/api/products/1
Content-Type: application/json
Accept: application/json

{
    "name": "Updated Product Name",
    "price": 39.99,
    "quantity": 50
}
```

#### Delete a Product

```http
DELETE http://localhost:8000/api/products/1
Accept: application/json
```

## Project Structure

```
app/
├── Http/
│   └── Controllers/
│       ├── CartController.php
│       └── ProductController.php
├── Models/
│   └── Product.php
routes/
├── api.php          # API routes (all endpoints here)
└── web.php          # Web routes (minimal, API-only project)
config/
└── cors.php         # CORS configuration
database/
├── migrations/
│   └── 2025_11_28_182800_create_products_table.php
└── database.sqlite
```

## Database

The project uses SQLite by default. The database file is located at `database/database.sqlite`.

### Product Schema

-   `id` - Primary key
-   `name` - Product name (required)
-   `description` - Product description (nullable)
-   `price` - Product price (decimal)
-   `quantity` - Available quantity (integer)
-   `created_at` - Timestamp
-   `updated_at` - Timestamp

## CORS Configuration

CORS is enabled for all API routes to allow cross-origin requests. The configuration is in `config/cors.php`. By default, all origins are allowed (`allowed_origins: ['*']`), and credentials are supported for session-based cart functionality.

## Testing

### Automated Tests

Run the test suite:

```bash
php artisan test
```

### Manual Testing with Postman

1. Import the API endpoints into Postman
2. Enable cookies in Postman settings
3. Start the Laravel server: `php artisan serve`
4. Test all endpoints as described in the API Endpoints section above

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
