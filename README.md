<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# API Documentation

This API allows for user registration, login, logout, and health check, as well as testing the database connection.

## Endpoints

### 1. Root Endpoints
#### `GET /`
Check if the API is conected correctly.

**Response:**
- **200 OK** - If the api is connected successfully.
- **404 Not Found** - If the api connection not found.

  Response:
  ```bash
   {
    "status": "200,
    "message": "API connection successfuly",
  }

### 2. AUTH Endpoints
#### `GET /auth/supabase/google`
**Response:**
- **200 OK** - If the api is connected successfully.
- **404 Not Found** - If the api connection not found.

  Response:
  ```bash
   {
    "status": "200,
    "message": "Login successfuly",
    "user" : {
            "id" : "user id",
            "user_uuid : "user uuid",
            "username" : "username"
            "fullname: " user fullname"
            "email" : "user email"
            "phone_number" : "user phone number"
            "status" : "user active status"
            "last_sign_in" : "user's last sign in date"
      },
      "token" : {
         "access_token" : "auth access token",
         "refresh_token : "auth refresh token"
      }
  }

