# Test Shop

A simple e-commerce shop application built with Laravel 12, featuring product management and shopping cart functionality.

## Features

-   **Product Management**: Full CRUD operations for products
-   **Shopping Cart**: Session-based shopping cart system
-   **RESTful API**: Product endpoints for integration
-   **Modern UI**: Clean and responsive user interface

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

The application will be available at `http://localhost:8000`

### Development with Hot Reload

For development with Vite hot module replacement:

```bash
npm run dev
```

In another terminal:

```bash
php artisan serve
```

### Quick Setup Script

You can use the setup script to install dependencies and configure the project:

```bash
composer run setup
```

## Routes

### Web Routes

-   `GET /` - Shop homepage
-   `GET /products` - List all products (JSON)
-   `GET /products/create` - Create product form
-   `POST /products` - Store new product
-   `GET /products/{id}` - Show product (JSON)
-   `PUT /products/{id}` - Update product
-   `DELETE /products/{id}` - Delete product
-   `GET /cart` - Shopping cart page
-   `GET /cart/api` - Get cart data (JSON)
-   `POST /cart/{id}` - Add product to cart
-   `DELETE /cart/{id}` - Remove product from cart

## Project Structure

```
app/
├── Http/
│   └── Controllers/
│       ├── CartController.php
│       └── ProductController.php
├── Models/
│   └── Product.php
resources/
└── views/
    ├── cart.blade.php
    ├── create-product.blade.php
    ├── shop.blade.php
    └── welcome.blade.php
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

## Testing

Run the test suite:

```bash
php artisan test
```

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
