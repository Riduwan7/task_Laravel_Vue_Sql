# Laravel + Vue Project Management System

## Repository

GitHub:
https://github.com/Riduwan7/task_Laravel_Vue_Sql

---

# Project Overview

This project is a **Laravel + Vue.js based Project Management System** with **three user roles**:

* Admin
* Developer
* Client

The system allows admins to manage users and projects, developers to update project progress, and clients to monitor project updates.

---

# Features

## Admin

* Dashboard with statistics
* Manage users (Admin / Developer / Client)
* Create and manage projects
* Assign developers and clients to projects
* View project status

## Developer

* View assigned projects
* View project details
* Add project updates
* Upload attachments

## Client

* View assigned projects
* Track project progress
* View updates uploaded by developers

---

# Technology Stack

Backend

* Laravel

Frontend

* Vue.js

Database

* MySQL

UI

* Bootstrap 5
* Tailwind css

Other

* Yajra DataTables
* SweetAlert

---

# Installation Guide

## 1 Clone the repository

```
git clone https://github.com/Riduwan7/task_Laravel_Vue_Sql.git
cd task_Laravel_Vue_Sql
```

---

## 2 Install dependencies

```
composer install
npm install
```

---

## 3 Setup environment

Copy `.env.sample`

```
cp .env.sample .env
```

Generate application key

```
php artisan key:generate
```

---

## 4 Configure database

Update `.env`

```
DB_DATABASE=task_laravel_vue
DB_USERNAME=root
DB_PASSWORD=
```

---

## 5 Import database

Import the provided SQL file:

```
database/task_laravel_vue.sql
```

using **phpMyAdmin** or **MySQL CLI**.

---

## 6 Storage link

```
php artisan storage:link
```

---

## 7 Run the application

```
php artisan serve
```

Open:

```
http://127.0.0.1:8000
```

---

# Login Credentials

## Admin

Email : admin@admin.com
Password : admin123

# Author

Riduwan

