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
  
#### `GET /auth/supabase/logout`
**Response:**
- **200 OK** - If the api is connected successfully.
- **404 Not Found** - If the api connection not found.
  

  ```bash
  {
   "status": "200,
   "message": "Logout successfuly",
    }


### 3. Press Release Endpoints
## Store New Press Release
#### `POST /press-releases`
 Create Form
 - Textarea name field => contents[index][content]
 - File Input Image name field => contents[index]][image]
    
  Request ( form data / multipart data ):
  ```bash
   {
    "title": "press release title" (required),
    "date": "YYYY-MM-DD" (required),
    "time": "Hours:Minute" (required),
    "contents" :array (required) {
          0 => array (nullable) {
            "content" : "string text content",
            "image"   : image file
         },
          1 => array (nullable) {
            "content" : "string text content",
            "image"   : image file
         },
        .........
  }
```
## Delete Press Release
#### `DELETE /press-releases /{press-release uuid}`
 Response:
  ```bash
   {
    "status": "200,
    "message": "Press release deleted successfully",
  }

 ```
## Read All Press Release
#### `GET /press-releases`
 Response:
  ```bash
   {
    "status": "200,
    "message": "Press releases retrieved successfully",
    "data" : [
        {
            id: press release id,
            press_uuid: "press release uuid",
            title: "press release title",
            date: "press release date",
            time: "press release create time",
            created_at: "2025-02-22T10:00:38.000000Z",
            updated_at: "2025-02-22T10:00:38.000000Z"
        }
        ...........

    ]
  }

 ```

## Read Press Release And Contents By UUID
#### `GET /press-releases /{press-release uuid}`

 Response:
  ```bash
   {
    "status": "200,
    "message": "Press releases retrieved successfully",
    "data" : [
        {
            id: press release id,
            press_uuid: "press release uuid",
            title: "press release title",
            date: "press release date",
            time: "press release create time",
            created_at: "2025-02-22T10:00:38.000000Z",
            updated_at: "2025-02-22T10:00:38.000000Z"
            contents: [
                        {
                        id: press release content id,
                        press_release_id: press release content id,
                        image_url: "press release content image url",
                        content: "press release content text",
                        created_at: "2025-02-22T10:00:38.000000Z",
                        updated_at: "2025-02-27T05:53:56.000000Z"
                        }
                    ...........
                    ]
        }
        ...........

    ]
  }

 ```
## Update Press Release And Content
Request ( form data / multipart data ):
  ```bash
   {
    "title": "press release title",
    "date": "YYYY-MM-DD",
    "time": "Hours:Minute",
    "contents" :array {
          0 => array {
            "content" : "string text content",
            "image"   : image file
         },
          1 => array {
            "content" : "string text content",
            "image"   : image file
         },
        .........
  }
```
  
  
