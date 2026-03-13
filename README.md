Smart Academic Task Manager

A modern PHP + MySQL web application designed to help students manage assignments, deadlines, and academic tasks efficiently.

The system includes task tracking, smart deadline detection, analytics dashboard, activity logging, and an interactive calendar scheduler.

Built with PHP, MySQL, JavaScript, and Tailwind CSS, this project demonstrates a complete full-stack CRUD productivity application.

---

Features

Authentication System

- Secure user registration
- Password hashing using PHP "password_hash"
- Login and logout with session management

Task Management

- Create tasks with course, deadline, and priority
- Edit tasks using modal interface
- Mark tasks as completed
- Delete tasks instantly using AJAX

Smart Deadline System

Automatically categorizes tasks based on deadline:

- Overdue
- Urgent (≤ 1 day)
- Upcoming (≤ 3 days)
- Normal

Dashboard Analytics

The dashboard displays:

- Total tasks
- Completed tasks
- Pending tasks
- Urgent tasks
- Task completion progress bar

Activity Feed

Logs all user actions:

- Task created
- Task updated
- Task completed
- Task deleted

Calendar Scheduling

Interactive calendar built using FullCalendar.

Features include:

- Monthly task view
- Drag-and-drop scheduling
- Automatic deadline updates

Task Filters & Search

Filter tasks by:

- All
- Pending
- Completed
- Urgent

Search tasks by title.

Guided Website Tour

Interactive onboarding built with Intro.js to help new users understand the interface.

---

Tech Stack

Frontend

- HTML
- Tailwind CSS
- JavaScript
- AJAX

Backend

- PHP
- MySQL

Libraries

- FullCalendar
- Intro.js

Development Environment

- XAMPP
- phpMyAdmin

---

Project Structure

smart-task-manager

config/
    database.php

auth/
    login.php
    register.php
    logout.php

tasks/
    add_task.php
    update_task.php
    delete_task.php
    complete_task.php

includes/
    auth_check.php

dashboard.php
tasks.php
calendar.php
index.php

---

Database Schema

Database name:

taskmanager

students

id
name
email
password

tasks

id
student_id
title
course
deadline
priority
status

activities

id
student_id
message
created_at

---

Installation

1 Install XAMPP

Download from:

https://www.apachefriends.org

Start:

- Apache
- MySQL

---

2 Clone Repository

git clone https://github.com/yourusername/smart-academic-task-manager.git

Move the project to:

xampp/htdocs/

---

3 Create Database

Open:

http://localhost/phpmyadmin

Create database:

taskmanager

Import the SQL tables.

---

4 Configure Database

Edit:

config/database.php

Example configuration:

$host = "localhost";
$user = "root";
$password = "";
$database = "taskmanager";

---

5 Run Project

Open:

http://localhost/smart-task-manager

---

Future Improvements

Possible enhancements include:

- Real-time dashboard updates
- Task analytics charts
- Mobile responsiveness improvements
- Notifications for upcoming deadlines

---

License

This project is released under the MIT License.

---

Author

Created by Mukhesh

---

Project Purpose

This project demonstrates:

- Full-stack PHP development
- Database design and integration
- AJAX-based UI interactions
- Interactive dashboard and task management system