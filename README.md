Markdown
# BonCard Hub - Gift Card Management System

BonCard Hub is a secure web application built with **Laravel 11** and **Laravel Breeze** (Blade & Tailwind CSS) designed for managing internal gift cards, tracking their live balances, and maintaining a robust system audit log.

The application has been fully patched against security threats including **Stored Cross-Site Scripting (XSS)** and **Privilege Escalation**, ensuring that all input handling and server-side operations follow industry-standard security practices.

---

## 🚀 Installation & Local Setup Guide

Follow these step-by-step instructions to get the application up and running on your local machine.

### Prerequisites
Make sure you have the following installed on your system:
* **PHP >= 8.2**
* **Composer** (PHP package manager)
* **Node.js & NPM** (For frontend assets compilation)
* **MySQL** or **MariaDB** database server (e.g., via XAMPP, Laragon, or Docker)

---

### Step 1: Clone the Repository
Clone this project to your local directory and enter the project folder:
```bash
git clone [https://github.com/YOUR_USERNAME/boncard-hub.git](https://github.com/YOUR_USERNAME/boncard-hub.git)
cd boncard-hub
Step 2: Install Backend Dependencies
Run Composer to download and install all required Laravel framework packages:

Bash
composer install
### Step 3: Install Frontend Dependencies
Download and compile the CSS and JavaScript assets necessary for the login layouts and Tailwind framework styling:

Bash
npm install
Step 4: Configure the Environment File
Create your local environment configuration file by copying the template file:

Bash
cp .env.example .env
Now, open the newly created .env file in your code editor and update the database credentials to match your local server environment:

Fragment kodu
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=boncard_db
DB_USERNAME=root
DB_PASSWORD=
(Make sure to create an empty database named boncard_db in your database manager like phpMyAdmin prior to the next step).

Step 5: Generate Application Key
Laravel requires a unique application key to encrypt user sessions and secure cookies:

Bash
php artisan key:generate
Step 6: Run Database Migrations
Create the necessary database tables (including users, password resets, cards, and transaction logs) by executing migrations:

Bash
php artisan migrate
Step 7: Build Frontend Assets
Compile the assets and launch the Vite build system. You can keep this running or compile for production:

Bash
# To run Vite asset tracking in the background during development:
npm run dev

# OR to build compressed production-ready assets once:
npm run build
🏃 How to Start the Application
Once the installation is complete, you can launch the local development server by executing:

Bash
php artisan serve