<div align="center">

# User Management API

**A Laravel 12 REST API with JWT authentication and role-based access control — powering the [Pial.Dev](https://portfolio-and-blog-app-fontend.vercel.app/) portfolio & blog platform.**

[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=flat&logo=php&logoColor=white)](https://php.net)
[![JWT](https://img.shields.io/badge/Auth-JWT-000000?style=flat&logo=jsonwebtokens)](https://github.com/tymondesigns/jwt-auth)
[![PostgreSQL](https://img.shields.io/badge/Database-PostgreSQL%20(Supabase)-3ECF8E?style=flat&logo=supabase&logoColor=white)](https://supabase.com)
[![Render](https://img.shields.io/badge/Deployed%20on-Render-46E3B7?style=flat&logo=render&logoColor=white)](https://render.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

</div>

---

## Overview

Despite the repository name, this API has grown beyond plain user CRUD — it's the full backend for a personal portfolio and blog platform: stateless JWT authentication, role-based access control (admin vs. user), and content management for skills, projects, blog posts, comments, likes, and contact-form submissions. It's designed to be consumed by a separate Vue 3 SPA, with CORS explicitly scoped to that frontend's origin.

The API was originally built and deployed on Railway with an Aiven MySQL database, then migrated to **Render** (Docker-based deploy) with **Supabase (PostgreSQL)** as the production database.

## Live Deployment

| | |
|---|---|
| **API** | [https://user-management-api-n936.onrender.com](https://user-management-api-n936.onrender.com) |
| **Database** | Supabase (PostgreSQL) |
| **Consumed by** | [Pial.Dev frontend](https://portfolio-and-blog-app-fontend.vercel.app/) — [source](https://github.com/mahmudpial/portfolio_and_blog_app_fontend) |

> **Note:** if hosted on Render's free tier, the service spins down after periods of inactivity — the first request after a while may take 30–50s to respond while it wakes up.

## Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 12 |
| Language runtime | PHP 8.4 (Docker image), PHP 8.2+ required |
| Authentication | JWT via `tymon/jwt-auth` |
| Database (production) | PostgreSQL — hosted on Supabase |
| Database (local dev) | SQLite |
| Deployment | Docker on Render |
| CORS | Explicitly scoped to the Vercel frontend origin |

## API Reference

**Base URL (production):** `https://user-management-api-n936.onrender.com/api`

All endpoints below are relative to this base (locally: `http://localhost:8000/api`).

### Auth

| Method | Endpoint | Description | Access |
|---|---|---|---|
| POST | `/auth/register` | Register a new account | Public |
| POST | `/auth/login` | Log in, receive a JWT | Public |
| POST | `/auth/forgot-password` | Request a password reset | Public |
| POST | `/auth/reset-password` | Reset password with token | Public |
| POST | `/auth/logout` | Invalidate the current token | Authenticated |
| POST | `/auth/refresh` | Refresh an expiring JWT | Authenticated |

### Current User

| Method | Endpoint | Description |
|---|---|---|
| GET | `/user/profile` | Get the authenticated user's profile |
| PUT | `/user/profile` | Update profile details |
| PUT | `/user/change-password` | Change password |

### Public Content

| Method | Endpoint | Description |
|---|---|---|
| GET | `/skills` | List all skills |
| GET | `/projects` | List portfolio projects |
| GET | `/projects/{project}` | Get a single project |
| GET | `/categories` | List post categories |
| GET | `/tags` | List post tags |
| GET | `/posts` | List published blog posts |
| GET | `/posts/{slug}` | Get a single post by slug |
| POST | `/posts/{id}/comments` | Submit a comment (pending approval) |
| POST | `/posts/{id}/likes` | Toggle a like on a post |
| POST | `/contacts` | Submit a contact-form message |

### Admin (requires `auth:api` + `admin` role)

| Method | Endpoint | Description |
|---|---|---|
| GET | `/admin/users` | List all users |
| GET | `/admin/users/{user}` | Get a single user |
| PUT | `/admin/users/{user}` | Update a user |
| DELETE | `/admin/users/{user}` | Delete a user |
| PATCH | `/admin/users/{user}/status` | Activate/suspend a user |
| POST/PUT/DELETE | `/admin/skills` | Manage skills |
| POST/PUT/DELETE | `/admin/categories` | Manage categories |
| POST/DELETE | `/admin/tags` | Manage tags |
| POST/PUT/DELETE | `/admin/projects` | Manage portfolio projects |
| GET/POST/PUT/DELETE | `/admin/posts` | Manage blog posts (including drafts) |
| GET | `/admin/comments` | List all comments |
| PATCH | `/admin/comments/{comment}/approve` | Approve a pending comment |
| DELETE | `/admin/comments/{comment}` | Delete a comment |
| GET | `/admin/contacts` | List contact-form submissions |
| PATCH | `/admin/contacts/{contact}/read` | Mark a message as read |
| DELETE | `/admin/contacts/{contact}` | Delete a message |

### Authentication Header

```
Authorization: Bearer <your_jwt_token>
```

## Data Model

| Table | Purpose |
|---|---|
| `users` | Accounts — `role` (`admin`/`user`) and `status` drive access control |
| `skills` | Portfolio skill list with proficiency percentage and category |
| `projects` | Portfolio project entries (title, links, featured flag, order) |
| `categories` | Blog post categories |
| `tags` / `post_tag` | Blog post tags (many-to-many) |
| `posts` | Blog posts — status, view count, belongs to a user and category |
| `comments` | Post comments — supports both registered users and guest name/email, requires admin approval |
| `likes` | Post likes — supports both registered users and anonymous guest tokens |
| `contacts` | Contact-form submissions with a read/unread flag |

## Getting Started

### Prerequisites
- PHP 8.2+ (8.4 recommended to match production)
- Composer
- Node.js (for asset compilation)
- SQLite (bundled, for local dev) or PostgreSQL/MySQL

### Local Setup

```bash
git clone https://github.com/mahmudpial/user-management-api.git
cd user-management-api

composer install
npm install

cp .env.example .env
php artisan key:generate
php artisan jwt:secret

# Local dev uses SQLite by default — no extra DB config needed
php artisan migrate

# Optional: seed an admin user + sample content
php artisan db:seed

php artisan serve
```

The API will be available at `http://localhost:8000/api`.

**Default seeded admin** (local/dev only — change immediately if reused anywhere real):
`admin@example.com` / `password`

### Running Tests

```bash
php artisan test
```

## Environment Variables

| Variable | Description |
|---|---|
| `APP_KEY` | Laravel application key |
| `DB_CONNECTION` | `sqlite` locally; `pgsql` in production (Supabase) |
| `DB_HOST` / `DB_PORT` / `DB_DATABASE` / `DB_USERNAME` / `DB_PASSWORD` | Supabase Postgres connection details in production |
| `JWT_SECRET` | Secret used to sign JWTs (`php artisan jwt:secret`) |
| `JWT_TTL` | Token lifetime in minutes (default: 60) |
| `SESSION_DRIVER` / `CACHE_STORE` / `QUEUE_CONNECTION` | Set to `database` |

> Never commit your `.env` file. On Render, set these as environment variables in the service dashboard instead.

## Deployment (Render + Supabase)

This API ships with a `Dockerfile` (PHP 8.4-FPM, with both `pdo_mysql` and `pdo_pgsql` drivers installed) so it can be deployed directly as a Docker service on Render:

1. Create a Supabase project and grab its Postgres connection credentials.
2. On Render, create a new **Web Service** from this repo and let it build from the included `Dockerfile`.
3. Set the environment variables above (`DB_CONNECTION=pgsql` plus the Supabase host/port/database/username/password, `APP_KEY`, `JWT_SECRET`).
4. The container's start command runs `php artisan migrate --force` automatically before starting the server.

## CORS

`config/cors.php` explicitly whitelists the production frontend origin (`https://portfolio-and-blog-app-fontend.vercel.app`) and `http://localhost:5173` for local development, with `supports_credentials` enabled.

## Project Structure

```
app/
├── Http/Controllers/Api/   # Auth, User, Admin, Skill, Category, Tag,
│                           # Project, Post, Comment, Like, Contact
└── Models/                 # User, Skill, Project, Category, Tag,
                             # Post, Comment, Like, Contact

database/
├── migrations/              # Full schema (users, content tables, pivot table)
└── seeders/                 # Admin user + sample categories/tags/posts

routes/
└── api.php                  # All API routes
```

## Roadmap

- [ ] Feature test coverage for auth, RBAC, and content endpoints (currently default scaffolding only)
- [ ] Rate limiting on public write endpoints (comments, likes, contact form)
- [ ] Image upload handling for post/project cover images (S3-compatible storage)
- [ ] API documentation via OpenAPI/Postman collection

## Related Repository

**Frontend:** [portfolio_and_blog_app_fontend](https://github.com/mahmudpial/portfolio_and_blog_app_fontend) — Vue 3 SPA, deployed on Vercel.

## License

Licensed under the [MIT License](LICENSE).

## Author

**Pial Mahmud**
Full-Stack Developer (Laravel & Vue 3)
[GitHub](https://github.com/mahmudpial) · [pialmahmud80@gmail.com](mailto:pialmahmud80@gmail.com)
