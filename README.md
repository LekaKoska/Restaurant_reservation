<h1>🍽️ Restaurant API Reservation</h1>
<p>
  A RESTful API for restaurant table reservations
</p>

---

## 📌 Project description

This Laravel REST API  allows users (guests) to:
-  Reserve a table at the restaurant,
-  Add a time to their reservation,
-  Cancel a reservation



> ⚠️ Only registered and email-verified users can access reservation features.

---

## 🎯 Features

✅ User registration and login

📬 Email verification as a requirement for reservations

🔐 Sanctum authentication via token

🪑 Fetch available tables

📝 Create and update reservations

🔗 Generate URLs for canceling or updating reservation time

📃 Swagger API documentation

---

## 🛠️ Technologies

| Technology         | Version       |
|--------------------|---------------|
| Laravel            | 12.x          |
| PHP                | 8.3           |
| MySQL              | 8+            |
| Laravel Sanctum    | ✅            |
| L5 Swagger         | ✅            |

---

## 🔐 Authentication
Laravel Sanctum is used for API authentication

After logging in, the user receives a token which must be sent in the request header:
```laravel
Authorization: Bearer {token}
```
---
## 🚀 Deployment
To deploy and run this Laravel application, follow the steps below:

# 📁 1. Clone the repository
```laravel
git clone https://github.com/your-username/Restaurant_api_reservation.git
cd Restaurant_api_reservation
```

# ⚙️ 2. Install dependencies
```laravel
composer install
```
# 🔐 3. Create .env file
```laravel
cp .env.example .env
```
# 🔑 4. Generate application key
```laravel
php artisan key:generate
```
# 🗄️ 5. Run migrations and seeders
```laravel
php artisan migrate --seed
```
# ▶️ 6. Start the server
```laravel
php artisan serve
```
--- 
## 🛠️ Testing

Below this text you will get few options and information how to  test this application.

 1. If you using some API platform to test:
     - You can test this application in [Postman](https://www.postman.com/).
       
 2. If you using Swagger:
    This project using [L5 Swagger](https://github.com/DarkaOnLine/L5-Swagger)
    
    - First step you need to generate Swagger
    ```laravel
    php artisan l5-swagger:generate
    ```
    - When you successfully generate Swagger you need to start server(**if you already start don't do this**)
    ```laravel
    php artisan serve
    ```
    - After that documentation will be available into this link
    ```laravel
    http://localhost:8000/api/documentation
    ```   
    
           
