<h1 align="center">Smart Academic Task Manager</h1><p align="center">
A modern <b>PHP + MySQL web application</b> designed to help students manage assignments, deadlines, and academic tasks efficiently.
</p><p align="center">
Built with <b>PHP, MySQL, JavaScript, and Tailwind CSS</b>.<br />
Live link: (http://smarttaskmanager.infinityfreeapp.com)
</p><hr><h2>Project Overview</h2><p>
Smart Academic Task Manager is a full-stack productivity web application that allows students to track academic tasks, manage deadlines, and monitor progress through a modern dashboard interface.
</p><p>
The system includes task management, analytics dashboard, activity tracking, and an interactive calendar scheduler.
</p><hr><h2>Features</h2><h3>Authentication System</h3><ul>
<li>Secure user registration</li>
<li>Password hashing using PHP <code>password_hash</code></li>
<li>Login and logout with session management</li>
</ul><h3>Task Management</h3><ul>
<li>Create tasks with course, deadline, and priority</li>
<li>Edit tasks using modal interface</li>
<li>Mark tasks as completed</li>
<li>Delete tasks instantly using AJAX</li>
</ul><h3>Smart Deadline System</h3><p>Tasks are automatically categorized based on deadlines:</p><ul>
<li>Overdue</li>
<li>Urgent (≤ 1 day)</li>
<li>Upcoming (≤ 3 days)</li>
<li>Normal</li>
</ul><h3>Dashboard Analytics</h3><ul>
<li>Total tasks</li>
<li>Completed tasks</li>
<li>Pending tasks</li>
<li>Urgent tasks</li>
<li>Task completion progress bar</li>
</ul><h3>Activity Feed</h3><p>The system logs important user actions:</p><ul>
<li>Task created</li>
<li>Task updated</li>
<li>Task completed</li>
<li>Task deleted</li>
</ul><h3>Calendar Scheduling</h3><p>
Interactive calendar built using <b>FullCalendar</b>.
</p><ul>
<li>Monthly task view</li>
<li>Drag-and-drop scheduling</li>
<li>Automatic deadline updates</li>
</ul><h3>Task Filters & Search</h3><ul>
<li>Filter tasks by status (All / Pending / Completed / Urgent)</li>
<li>Search tasks by title</li>
</ul><h3>Guided Website Tour</h3><p>
An interactive onboarding guide built with <b>Intro.js</b> helps new users understand the interface.
</p><hr><h2>Tech Stack</h2><h3>Frontend</h3><ul>
<li>HTML</li>
<li>Tailwind CSS</li>
<li>JavaScript</li>
<li>AJAX</li>
</ul><h3>Backend</h3><ul>
<li>PHP</li>
<li>MySQL</li>
</ul><h3>Libraries</h3><ul>
<li>FullCalendar</li>
<li>Intro.js</li>
</ul><h3>Development Environment</h3><ul>
<li>XAMPP</li>
<li>phpMyAdmin</li>
</ul><hr><h2>Project Structure</h2><pre>
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
</pre><hr><h2>Database Schema</h2><p><b>Database name:</b></p><pre>taskmanager</pre><h3>students</h3><pre>
id
name
email
password
</pre><h3>tasks</h3><pre>
id
student_id
title
course
deadline
priority
status
</pre><h3>activities</h3><pre>
id
student_id
message
created_at
</pre><hr><h2>Installation</h2><h3>1 Install XAMPP</h3><p>Download from:</p><p>https://www.apachefriends.org</p><p>Start the following services:</p><ul>
<li>Apache</li>
<li>MySQL</li>
</ul><h3>2 Clone Repository</h3><pre>
git clone https://github.com/yourusername/smart-academic-task-manager.git
</pre><p>Move the project to:</p><pre>
xampp/htdocs/
</pre><h3>3 Create Database</h3><p>Open:</p><pre>
http://localhost/phpmyadmin
</pre><p>Create database:</p><pre>
taskmanager
</pre><p>Import the SQL tables.</p><h3>4 Configure Database</h3><p>Edit:</p><pre>
config/database.php
</pre><p>Example configuration:</p><pre>
$host = "localhost";
$user = "root";
$password = "";
$database = "taskmanager";
</pre><h3>5 Run Project</h3><pre>
http://localhost/smart-task-manager
</pre><hr><h2>Future Improvements</h2><ul>
<li>Real-time dashboard updates</li>
<li>Task analytics charts</li>
<li>Mobile responsive improvements</li>
<li>Notifications for upcoming deadlines</li>
</ul><hr><h2>License</h2><p>
This project is released under the <b>MIT License</b>.
</p><hr><h2>Author</h2><p>
Created by <b>Mukhesh</b>
</p><hr><h2>Project Purpose</h2><p>This project demonstrates:</p><ul>
<li>Full-stack PHP development</li>
<li>Database design and integration</li>
<li>AJAX-based UI interactions</li>
<li>Interactive dashboard and task management system</li>
</ul>
