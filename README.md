<h1 align="center">🍽️ Restaurant API Reservation</h1>
<p align="center">
  A RESTful API for restaurant table reservations
</p>

---

## 📌 Project description

This Laravel REST API  allows users (guests) to:
- 📅 Reserve a table at the restaurant,
- 🕒 Add a time to their reservation,
- ❌ Cancel a reservation



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

Authorization: Bearer {token}

# 📁 1. Clone the repository
git clone https://github.com/your-username/Restaurant_api_reservation.git
cd Restaurant_api_reservation

# ⚙️ 2. Install dependencies
composer install

# 🔐 3. Create .env file
cp .env.example .env

# 🗄️ 4. Run migrations and seeders
php artisan migrate --seed

# 🔑 5. Generate application key
php artisan key:generate

# ▶️ 6. Start the server
php artisan serve

