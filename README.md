# Product Verification API

## Setup

1. Clone the repository
2. Run `composer install`
3. Copy `.env.example` to `.env`
4. Run `php artisan key:generate`
5. Create a database and update the `.env` file
6. Run `php artisan migrate --seed`

## API Usage

### Verify QR Code

- **Endpoint:** `/api/verify`
- **Method:** `POST`
- **Body:**
  ```json
  {
      "qr_code": "...",
      "device_id": "...",
      "geo_location": {
          "lat": ...,
          "lng": ...
      }
  }
  ```

### Get All Products

- **Endpoint:** `/api/products`
- **Method:** `GET`

### Create Product

- **Endpoint:** `/api/products`
- **Method:** `POST`
- **Body:**
  ```json
  {
      "product_name": "...",
      "batch_number": "...",
      "status": "..."
  }
  ```

### Get Product

- **Endpoint:** `/api/products/{id}`
- **Method:** `GET`

### Update Product

- **Endpoint:** `/api/products/{id}`
- **Method:** `PUT`
- **Body:**
  ```json
  {
      "product_name": "...",
      "batch_number": "...",
      "status": "..."
  }
  ```

### Delete Product

- **Endpoint:** `/api/products/{id}`
- **Method:** `DELETE`

### Generate QR Code

- **Endpoint:** `/api/products/{id}/generate-qr`
- **Method:** `POST`

### Get Scan Logs

- **Endpoint:** `/api/scan-logs`
- **Method:** `GET`

## Bulk Import

1. Go to the admin panel
2. Click on "Products"
3. Click on "Import"
4. Upload a CSV/Excel file with the following columns: `product_name`, `batch_number`, `status`
