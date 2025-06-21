# 💸 Expense Tracker API

A RESTful Expense Tracking API built with Laravel. This application allows users to manage their daily expenses, categories, and generate reports – all through a secure and modern API.

---

## 📌 Features

- 🔐 User Authentication (Register/Login/Logout)
- 🧾 Expense CRUD operations
- 🗂️ Category management
- 📊 Monthly & category-wise reporting
- 📅 Date-filtered expense listing
- 🔁 Support for recurring expenses
- 📤 JSON API responses for all operations

---

## 🚀 Getting Started

### 🛠️ Requirements

- PHP >= 8.1
- Composer
- Laravel 10+
- MySQL or any other supported DB
- Postman / Insomnia (for API testing)

### ⚙️ Installation

```bash
git clone https://github.com/Dhruvkotak1/ExpenseTrackerApi.git
cd ExpenseTrackerApi

composer install
cp .env.example .env
php artisan key:generate

```
API Endpoints
| Method | Endpoint              | Description                    |
| ------ | --------------------- | ------------------------------ |
| POST   | `/api/register`       | Register a new user            |
| POST   | `/api/login`          | Login and get token            |
| GET    | `/api/aprofile`       | Get authenticated user profile |
| POST   | `/api/expenses`       | Add a new expense              |
| GET    | `/api/expenses`       | List all expenses              |
| PUT    | `/api/expenses/{id}`  | Update an expense              |
| DELETE | `/api/expenses/{id}`  | Delete an expense              |
| GET    | `/api/categories`     | List all categories            |
| POST   | `/api/categories`     | Create a new category          |
| GET    | `/api/report/monthly` | Get monthly expense report     |

📚 Tech Stack
Laravel 10
Laravel Sanctum (for Auth)
MySQL
Eloquent ORM
REST API
Validation & Middleware

👨‍💻 Developer
Kotak Dhruv Girishbhai
