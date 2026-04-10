# 🛡️ User Management API

A **Laravel 12** RESTful API for user management with JWT authentication, role-based access control, and MySQL database — deployable on Railway with a Vue.js frontend on Vercel.

---

## 🧰 Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 12 (PHP) |
| Database | MySQL |
| Authentication | JWT (`tymon/jwt-auth`) |
| Session/Cache | Database driver |
| Frontend | Vue.js (separate repo, deployed on Vercel) |
| Deployment | Railway (backend) + Aiven (MySQL) |

---

## ⚙️ Requirements

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js (for frontend assets / Vite)
- XAMPP or any local server (for local development)

---

## 🚀 Local Setup

### 1. Clone the repository

```bash
git clone https://github.com/your-username/user-management-api.git
cd user-management-api
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

Update your `.env` with local DB credentials:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=user_management_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate JWT secret

```bash
php artisan jwt:secret
```

### 5. Run migrations

```bash
php artisan migrate
```

### 6. Seed the database (optional)

```bash
php artisan db:seed
```

### 7. Start the development server

```bash
php artisan serve
```

API will be available at: `http://localhost:8000`

---

## 🔑 Authentication

This API uses **JWT (JSON Web Tokens)** for stateless authentication.

| Method | Endpoint | Description |
|---|---|---|
| POST | `/api/auth/register` | Register a new user |
| POST | `/api/auth/login` | Login and receive JWT token |
| POST | `/api/auth/logout` | Logout (invalidate token) |
| GET | `/api/auth/me` | Get authenticated user |

Include the token in the `Authorization` header:

```
Authorization: Bearer <your_token>
```

---

## 👥 User Endpoints

| Method | Endpoint | Description | Role Required |
|---|---|---|---|
| GET | `/api/users` | List all users | Admin |
| GET | `/api/users/{id}` | Get a single user | Admin / Self |
| PUT | `/api/users/{id}` | Update user | Admin / Self |
| DELETE | `/api/users/{id}` | Delete user | Admin |

---

## 🌍 Environment Variables

| Variable | Description |
|---|---|
| `APP_KEY` | Laravel application key |
| `DB_*` | Database connection settings |
| `JWT_SECRET` | Secret key for signing JWT tokens |
| `SESSION_DRIVER` | Set to `database` |
| `CACHE_STORE` | Set to `database` |
| `QUEUE_CONNECTION` | Set to `database` |

> ⚠️ **Never commit your `.env` file to version control.**

---

## 🚂 Railway Deployment

1. Push your code to GitHub.
2. Create a new Railway project and connect your repo.
3. Add the following environment variables in Railway dashboard (same as your `.env`).
4. Set the start command:

```bash
php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
```

5. Connect an **Aiven MySQL** instance and update `DB_*` variables with SSL settings:

```dotenv
DB_HOST=<aiven-host>
DB_PORT=<aiven-port>
DB_DATABASE=<your-db>
DB_USERNAME=<your-user>
DB_PASSWORD=<your-password>
MYSQL_ATTR_SSL_CA=/etc/ssl/certs/ca-certificates.crt
```

---

## 🖥️ Frontend

The Vue.js frontend is hosted separately on **Vercel**.

- Frontend Repo: [your-frontend-repo-link]
- API Base URL must be set in the frontend `.env`:

```dotenv
VITE_API_BASE_URL=https://your-railway-app.up.railway.app
```

---

## 🔒 Security Notes

- JWT tokens expire based on `JWT_TTL` config (default: 60 minutes).
- Passwords are hashed using **bcrypt** with `BCRYPT_ROUNDS=12`.
- OWASP best practices followed for input validation and error handling.

---

## 📁 Project Structure

```
├── app/
│   ├── Http/Controllers/     # API Controllers
│   ├── Models/               # Eloquent Models
│   └── Middleware/           # Auth & Role Middleware
├── database/
│   ├── migrations/           # DB Migrations
│   └── seeders/              # DB Seeders
├── routes/
│   └── api.php               # API Routes
├── .env.example              # Environment template
└── README.md
```

---

## 📄 License

This project is open-source and available under the [MIT License](LICENSE).

---

## 🙋‍♂️ Author

**Pial Mahmud**
Full Stack Web Developer | CSE Student @ Daffodil International University
[GitHub](https://github.com/mahmudpial) · [Portfolio](https://portfolio-and-blog-app-fontend.vercel.app/)
