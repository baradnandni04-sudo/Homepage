# BrightLedger registration and login app

A PHP and MySQL registration/login application with a responsive Bootstrap 5 interface, client- and server-side validation, PDO queries, password hashing, CSRF-protected forms, and a private user dashboard.

## Requirements

- XAMPP with Apache, PHP 8.1+ and MySQL/MariaDB
- PHP extensions `pdo` and `pdo_mysql` enabled
- A modern browser with an internet connection to load the Bootstrap CDN assets

## XAMPP setup

1. Copy the project folder into `C:\xampp\htdocs\` (for example, `C:\xampp\htdocs\brightledger`).
2. Open the XAMPP Control Panel and start **Apache** and **MySQL**.
3. Open `http://localhost/phpmyadmin`.
4. Choose **Import**, select this project's `database.sql`, then select **Import**. The script creates the dedicated `brightledger_registration` database and its `users` table. Alternatively, open the SQL tab, paste the file contents, and run it.
5. If your local MySQL uses XAMPP's defaults (`root` with an empty password), no further configuration is needed. To use different credentials, set `DB_HOST`, `DB_NAME`, `DB_USER`, and `DB_PASSWORD` in the Apache/PHP environment before starting Apache. Defaults are `127.0.0.1`, `brightledger_registration`, `root`, and an empty password.
6. Visit `http://localhost/brightledger/` (replace `brightledger` with the folder name you chose).
7. Register a user, sign in, and review the profile displayed on the dashboard. Use **Sign out** to end the session.

## Included pages and behavior

- `index.php`: home page
- `register.php`: server-side validation, duplicate-email prevention, and secure password hashing
- `login.php`: prepared database lookup and `password_verify`
- `dashboard.php`: authenticated retrieval and display of the current user's details
- `logout.php`: CSRF-protected POST logout
- `config/database.php`: lazy PDO/MySQL connection
- `database.sql`: database and table schema

Database connection failures are logged to the PHP error log; the pages show a safe message instead of exposing database credentials or internal errors.

The existing `student_fees_management` database on the development machine has a different `users` schema. This app uses its own database so those existing tables and records remain untouched.
