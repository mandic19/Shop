# Shop API

This repository contains a Laravel-based Shop API that simulates a third-party e-commerce API with daily updates. The application runs in Docker containers with PHP 8.4 and the latest Laravel framework version.

## System Requirements

- Docker and Docker Compose (all other dependencies are handled within containers)

## Project Setup

### 1. Clone the Repository

```bash
git clone https://github.com/mandic19/Shop.git
cd Shop
```

### 2. Environment Configuration

Create a `.env` file based on the provided example:

```bash
cp .env.example .env
```

Make any necessary adjustments to the environment variables in the `.env` file before proceeding.

### 3. Host Configuration

Add the following line to your hosts file:

```
127.0.0.1 api.shop.local
```

* On Linux/Mac: `/etc/hosts`
* On Windows: `C:\Windows\System32\drivers\etc\hosts`

### 4. Start Docker Containers

```bash
docker-compose up -d
```

### 5. Install Dependencies

Access the PHP-FPM container and install Composer dependencies:

```bash
docker exec -it shop-php-fpm bash
composer install
```

### 6. Run Migrations

Set up the database tables:

```bash
docker exec -it shop-php-fpm bash
php artisan migrate
```

## API Documentation

The API documentation is available through Swagger UI at:

```
http://api.shop.local/api/documentation
```

## Shop Seeder

The application includes a seeder to simulate daily third-party API updates.

### Seeder Command

```bash
docker exec -it shop-php-fpm bash
php artisan db:seed:shop
```

This command is configured to run daily via crontab.

### Command Options

```
--products=10     : Number of products to generate (default: 10)
--variants=3      : Number of variants per product (default: 3)
--product-images=1: Number of images per product (default: 1)
--variant-images=2: Number of images per variant (default: 2)
```

### Usage Examples

Generate 5 products with 2 variants each and custom image counts:
```bash
php artisan db:seed:shop --products=5 --variants=2 --product-images=3 --variant-images=1
```

## Scheduled Updates

The seeder command is scheduled via crontab to execute daily to simulate real-world API updates.

## License

This project is licensed under the MIT License - see the LICENSE file for details.
