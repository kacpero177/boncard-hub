# BonCard Hub - Gift Card Management System

## 📸 Application Preview
<img src="https://github.com/user-attachments/assets/2ef4250e-efbc-405f-aab0-34c9576c6381" width="100%">
<img src="https://github.com/user-attachments/assets/59ed3d03-fdb5-47c0-9e63-228b47dbf5e9" width="100%">
<img src="https://github.com/user-attachments/assets/5be70cdd-af13-4f35-ac99-e96d7a6c8579" width="100%">
<img src="https://github.com/user-attachments/assets/33100b81-5dd6-4b98-bd76-8fce60d8212b" width="100%">

BonCard Hub is a secure web application...


# BonCard Hub - Gift Card Management System

BonCard Hub is a secure web application built with **Laravel 11** and **Laravel Breeze** (Blade & Tailwind CSS) designed for managing internal gift cards, tracking their live balances, and maintaining a robust system audit log.

The application has been fully patched against security threats including **Stored Cross-Site Scripting (XSS)** and **Privilege Escalation**, ensuring that all input handling and server-side operations follow industry-standard security practices.

---

## Installation & Local Setup Guide

Follow these step-by-step instructions to get the application up and running on your local machine from scratch.

### Prerequisites
Make sure you have the following installed on your system before starting:
* **PHP >= 8.2**
* **Composer** (PHP package manager)
* **Node.js & NPM** (For frontend assets compilation)
* **MySQL** or **MariaDB** database server (e.g., via XAMPP, Laragon, or Docker)

---

### Step 1: Clone the Repository
Clone this project to your local directory by providing the repository URL, then enter the project folder:
git clone https://github.com/kacpero177/boncard-hub.git
cd boncard-hub

### Step 2: Install Backend Dependencies
Run Composer to download and install all required Laravel framework packages:
composer install

### Step 3: Install Frontend Dependencies
Download and compile the CSS and JavaScript assets necessary for the login layouts and Tailwind framework styling:
npm install

### Step 4: Configure the Environment File
Create your local environment configuration file by copying the template file:
cp .env.example .env

Now, open the newly created .env file in your code editor and update the database credentials to match your local server environment:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=boncard_db
DB_USERNAME=root
DB_PASSWORD=

(Note: Make sure to create an empty database named boncard_db in your database manager like phpMyAdmin prior to running migrations).

### Step 5: Generate Application Key
Laravel requires a unique application key to encrypt user sessions and secure cookies:
php artisan key:generate

### Step 6: Run Database Migrations
Create the necessary database tables (including users, password resets, cards, and transaction logs) by executing database migrations:
php artisan migrate

### Step 7: Build Frontend Assets
Compile the assets and launch the Vite build system to handle frontend development styling:
npm run dev

---

## 🏃 How to Start the Application

Once the installation is complete, you can launch the local development server by executing:
php artisan serve

The terminal will provide a local address. Open your web browser and navigate to:
👉 http://127.0.0.1:8000

### Core Features Implemented:
1. Authentication: Full login, registration ("Register new account"), and password management built via secure Breeze scaffolding.
2. Access Control: All critical routes /cards/* are fully protected via the server-side auth middleware, restricting public access.
3. Secure Audit Trail: Every card modification triggers an untamperable database transaction event logging details securely.
4. XSS Protection: Output sanitization implemented inside show.blade.php timeline nodes preventing payload command execution.