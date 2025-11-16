# Product Verification API (Laravel + MySQL)

This backend powers a Flutter app that scans product QR codes and detects whether the product is original, fake, or suspicious (cloned).

## Features
- Verify QR codes
- Detect cloned QR codes (scan_count > 1)
- Store product details and batch numbers
- REST API endpoint ready for mobile applications

## Installation

composer install  
cp .env.example .env  
php artisan key:generate  

Configure MySQL in `.env`  
Run migrations: php artisan migrate  
Start server: php artisan serve  

POST /api/verify

Body:
{
  "qr": "YOUR_CODE"
}
