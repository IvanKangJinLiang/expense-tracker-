# Expense Tracker

A full-stack Expense Tracker application built with **Laravel** and **Vue 3**. This application allows users to manage daily expenses with features including creating, viewing, updating, and deleting records (CRUD). It utilizes a modern tech stack with real-time validation and dynamic currency formatting.

## Tech Stack

* **Backend:** Laravel 10/11
* **Frontend:** Vue 3 (Composition API)
* **Styling:** Tailwind CSS
* **Database:** MySQL
* **Build Tool:** Vite

## Prerequisites

Before setting up the project, ensure you have the following installed:

* **PHP** (8.1 or higher)
* **Composer** (PHP Dependency Manager)
* **Node.js & NPM** (JavaScript Runtime)
* **MySQL Server**

## Installation Guide

Follow these steps to get the project running on your local machine.

### 1. Clone the Repository

```bash
git clone https://github.com/IvanKangJinLiang/expense-tracker-.git
cd expense-tracker-
```

### 2. Install Dependencies
Install the backend PHP packages:
```bash
composer install
```
Install the frontend JavaScript packages:
```bash
npm install
```

### 3.Environment Configuration
Copy the example environment file to create your local configuration:
```bash
cp .env.example .env
```
Open the .env file and configure your database settings. By default, this project looks for a database named mdigitals.
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mdigitals
DB_USERNAME=root
DB_PASSWORD=
```
Generate the application encryption key:
```bash
php artisan key:generate
```

### 4. Database Setup
1.Open your MySQL client (phpMyAdmin).
2.Create a new database named mdigitals (or whatever you named it in your .env file).
3.Run the migrations to create the expenses table:
```bash
php artisan migrate
```

### 5. Running The Application
This project uses Vite, so you must run both the backend server and the frontend build process simultaneously.
Terminal 1: Start Laravel Backend
```bash
php artisan serve
```

Terminal 2: Start Vite Frontend
```bash
npm run dev
```
Access the application in your browser at: http://127.0.0.1:8000