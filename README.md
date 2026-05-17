# Laravel Exam — PT. XYZ Tax Calculator

A simple Laravel application for calculating employee income tax for PT. XYZ. The project uses Laravel for the backend and Blade views, with Tailwind CSS compiled through Vite for the frontend styling.

## Tech Stack

- PHP 8.3+
- Laravel 13
- Composer
- Node.js and npm
- Vite
- Tailwind CSS
- MySQL

---

# Requirements

Before running this project, make sure these tools are installed on your machine:

- PHP 8.3 or newer
- MySQL
- Composer
- Node.js and npm
- Git

Check installation:

```bash
php -v
composer -V
node -v
npm -v
git --version
```

---

# Installation Guide

Follow these steps after cloning the repository.

## 1. Clone the repository

```bash
git clone https://github.com/hicesse/laravelExam.git
cd laravelExam
```

---

## 2. Install PHP dependencies

```bash
composer install
```

---

## 3. Install JavaScript dependencies

```bash
npm install
```

This project uses Tailwind CSS through Vite, so npm dependencies are required.

---

## 4. Create the environment file

### Linux / macOS

```bash
cp .env.example .env
```

### Windows PowerShell

```powershell
Copy-Item .env.example .env
```

---

## 5. Generate application key

```bash
php artisan key:generate
```

---

## 6. Configure database

Update `.env` to choose your database.

### Create SQLite database file

### Linux / macOS

```bash
mkdir -p database
touch database/database.sqlite
```

### Windows PowerShell

```powershell
New-Item -ItemType File -Path database/database.sqlite -Force
```

Make sure `.env` contains:

```env
DB_CONNECTION=sqlite
```

---

### Optional: Use MySQL instead

Update `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=
```

Then create the database manually in MySQL.

---

## 7. Run migrations

```bash
php artisan migrate
```

If seeders are available later:

```bash
php artisan db:seed
```

Or:

```bash
php artisan migrate --seed
```

---

# Running the Project

This project requires both Laravel server and Vite development server running simultaneously.

## Terminal 1 — Run Laravel

```bash
php artisan serve
```

Laravel usually runs at:

```text
http://127.0.0.1:8000
```

---

## Terminal 2 — Run Vite / Tailwind

```bash
npm run dev
```

Keep this terminal running during development so Tailwind and frontend assets compile correctly.

---

# Open the Project

Visit:

```text
http://127.0.0.1:8000
```

---

# Alternative Development Command

This project also includes:

```bash
composer run dev
```

This may run Laravel server and Vite together depending on your environment.

If it does not work properly, use the two-terminal method above.

---

# Production Build

Build frontend assets for production:

```bash
npm run build
```

---

# Common Problems

## Tailwind styling does not appear

Run:

```bash
npm install
npm run dev
```

And make sure the Vite terminal is still running.

---

## APP_KEY error

Run:

```bash
php artisan key:generate
```

---

## Database file does not exist

If using SQLite:

### Linux / macOS

```bash
touch database/database.sqlite
```

### Windows PowerShell

```powershell
New-Item -ItemType File -Path database/database.sqlite -Force
```

Then run:

```bash
php artisan migrate
```

---

## Page loads but CSS is broken

Run both servers:

```bash
php artisan serve
npm run dev
```

They must run in separate terminals.

---

# Notes

- Do not commit your `.env` file.
- Use `.env.example` as the configuration template.
- Tailwind CSS is handled through Vite, not CDN.
- Laravel Boost is not required to run the main application.

---

# License

This project is for learning and examination purposes.
