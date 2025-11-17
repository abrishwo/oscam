# Product Verification API

This is a production-ready Laravel + MySQL backend for a Product Verification System. This backend is designed to be used by a Flutter mobile app that scans alcohol product QR codes and verifies whether the product is ORIGINAL, FAKE, or SUSPICIOUS (cloned).

## Features

- **Advanced Verification Logic:** Detects cloned QR codes using scan counts, device IDs, and time-based analysis.
- **Secure API:** Built with Laravel Sanctum for token-based authentication, with rate limiting and CORS configuration.
- **Product Management:** Complete CRUD functionality for managing products.
- **Scan Logging:** Records detailed information about each scan, including device ID and geo-location.
- **QR Code Generation:** API endpoints for generating unique QR codes for products.
- **API Documentation:** Includes an OpenAPI (Swagger) specification for clear and comprehensive documentation.

## Getting Started

### Prerequisites

- PHP >= 8.1
- Composer
- MySQL
- Node.js & npm (for frontend assets, if any)

### Installation

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/your-username/product-verification-api.git
    cd product-verification-api
    ```

2.  **Install dependencies:**
    ```bash
    composer install
    ```

3.  **Set up the environment:**
    -   Copy the `.env.example` file to `.env`:
        ```bash
        cp .env.example .env
        ```
    -   Generate an application key:
        ```bash
        php artisan key:generate
        ```
    -   Configure your database credentials in the `.env` file:
        ```
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=product_verification_api
        DB_USERNAME=root
        DB_PASSWORD=
        ```

4.  **Run the database migrations:**
    ```bash
    php artisan migrate
    ```

5.  **Start the development server:**
    ```bash
    php artisan serve
    ```

## Database Schema

The database consists of two main tables: `products` and `scans`.

### `products` table

| Column         | Type        | Modifiers                               |
| -------------- | ----------- | --------------------------------------- |
| `id`           | `bigint`    | `unsigned`, `auto-increment`, `primary` |
| `qr_code`      | `string`    | `unique`                                |
| `product_name` | `string`    |                                         |
| `batch_number` | `string`    |                                         |
| `status`       | `enum`      | `'original'`, `'fake'`                  |
| `scan_count`   | `integer`   | `default: 0`                            |
| `last_scan`    | `timestamp` | `nullable`                              |
| `created_at`   | `timestamp` |                                         |
| `updated_at`   | `timestamp` |                                         |

### `scans` table

| Column        | Type        | Modifiers                               |
| ------------- | ----------- | --------------------------------------- |
| `id`          | `bigint`    | `unsigned`, `auto-increment`, `primary` |
| `product_id`  | `bigint`    | `unsigned`, `foreign`                   |
| `scanned_at`  | `timestamp` |                                         |
| `device_id`   | `string`    | `nullable`                              |
| `geo_location`| `json`      | `nullable`                              |
| `user_agent`  | `string`    | `nullable`                              |
| `created_at`  | `timestamp` |                                         |
| `updated_at`  | `timestamp` |                                         |

## API Usage

### Authentication

The API uses Laravel Sanctum for authentication. To access protected endpoints, you need to obtain a token and include it in the `Authorization` header of your requests:

```
Authorization: Bearer <your-token>
```

### Endpoints

-   `POST /api/verify`: Verify a product by its QR code.
-   `GET /api/products`: Get a list of all products.
-   `POST /api/products`: Create a new product.
-   `GET /api/products/{id}`: Get a single product by ID.
-   `PUT /api/products/{id}`: Update a product.
-   `DELETE /api/products/{id}`: Delete a product.
-   `GET /api/products/{product}/generate-qr`: Generate a QR code for a product.
-   `POST /api/register`: Register a new user.
-   `POST /api/login`: Log in a user.
-   `POST /api/logout`: Log out a user.

### Example Requests

#### Verify a Product

```bash
curl -X POST http://localhost:8000/api/verify \
  -H "Content-Type: application/json" \
  -d '{
    "qr_code": "your-qr-code-string",
    "device_id": "your-device-id"
  }'
```

#### Create a Product

```bash
curl -X POST http://localhost:8000/api/products \
  -H "Authorization: Bearer <your-token>" \
  -H "Content-Type: application/json" \
  -d '{
    "product_name": "Premium Lager",
    "batch_number": "B12345"
  }'
```

## Security

-   **Authentication:** All administrative endpoints are protected by Laravel Sanctum.
-   **Validation:** All incoming requests are validated using Form Requests.
-   **Rate Limiting:** The API is configured with a rate limiter to prevent abuse.
-   **CORS:** The CORS policy is configured to allow requests from your Flutter application.

## Deployment

This project is ready for deployment on a variety of platforms, including cPanel, VPS, or Docker. Ensure that you have configured your `.env` file with the correct production settings before deploying.

## Admin Panel

This project includes a simple admin panel for managing products. You can access the admin panel by visiting the `/admin/login` route in your browser.

## API Documentation

The API documentation is available at the `/api/docs` route. This will open a Swagger UI interface that allows you to explore and test the API endpoints.

## Versioning

This project follows [Semantic Versioning](https://semver.org/).

---
*This README was generated by an AI assistant.*
