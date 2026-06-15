# 💊 Medicine API

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

A fast, secure, and beautifully documented RESTful API for managing medical data, prescriptions, and pharmaceutical inventory. Built with Laravel 11.

## ✨ Features

- ⚡️ **Lightning Fast**: Optimized queries and response formatting.
- 🔒 **Secure Authorization**: Uses Static Token Authentication for secured API endpoints.
- 🛡️ **Rate Limiting**: Protects endpoints against DDoS and brute-force attacks (60 requests/minute).
- 🛠️ **Unified Error Handling**: Provides a consistent, predictable JSON response format across all endpoints.
- 📦 **Data Integrity**: Uses robust database transactions for all Create, Update, and Delete operations.

---

## 🚀 Getting Started

### Prerequisites

- PHP >= 8.2
- Composer
- MySQL/MariaDB
- Laragon (or similar local development environment)

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/medicine-app.git
   cd medicine-app
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Environment Setup:**
   ```bash
   cp .env.example .env
   ```
   Update the database credentials and API Token in your `.env` file:
   ```env
   DB_DATABASE=medicine_app
   DB_USERNAME=root
   DB_PASSWORD=

   # Custom API Configuration
   API_STATIC_TOKEN=your_secret_token_here
   ```

4. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

5. **Run Migrations & Seeders:**
   ```bash
   php artisan migrate --seed
   ```

6. **Serve the Application:**
   If using Laragon, the app is available at `http://medicine-app.test`. Alternatively, run:
   ```bash
   php artisan serve
   ```

---

## 📡 API Endpoints

### 🔐 Authentication

To access secured endpoints, pass your token in the headers:
```http
Authorization: Bearer your_secret_token_here
```
*(Alternatively, you can use the `X-API-Key` header)*

### ⚕️ Medicines

| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `GET` | `/api/medicines` | Retrieve a paginated list of all medicines. |
| `POST` | `/api/medicines` | Create a new medicine record. |
| `GET` | `/api/medicines/{slug}` | Get details of a specific medicine by its slug. |
| `PUT` | `/api/medicines/{slug}` | Update an existing medicine record. |
| `DELETE` | `/api/medicines/{slug}` | Delete a medicine record. |

---

## 📤 Standardized JSON Responses

### ✅ Success Response
```json
{
    "status": true,
    "message": "Medicines retrieved successfully",
    "products": [...]
}
```

### ❌ Error Response (e.g. 404 Not Found)
```json
{
    "status": false,
    "message": "The requested medicine data could not be found.",
    "error_code": 404
}
```

### ⚠️ Validation Error
```json
{
    "status": false,
    "message": "Validation failed.",
    "error_code": 422,
    "errors": {
        "title": ["The title field is required."]
    }
}
```

---

## 🛡️ Security Checks for Production

Before deploying to a production server, ensure that:
- `APP_ENV=production` is set in the `.env` file.
- `APP_DEBUG=false` is strictly enforced to prevent stack trace leaks.
- CORS (`config/cors.php`) is configured to allow only trusted front-end domains.
- Consider migrating from a Static Token to Laravel Sanctum if expanding for multi-user/multi-client access.

---

<p align="center">Made with ❤️ using Laravel</p>
