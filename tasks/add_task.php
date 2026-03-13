<?php
include("../includes/auth_check.php");
include("../config/database.php");

$student_id = $_SESSION['student_id'];

if(isset($_POST['add_task']))
{

$title = $_POST['title'];
$course = $_POST['course'];
$deadline = $_POST['deadline'];
$priority = $_POST['priority'];

$stmt = $conn->prepare(
"INSERT INTO tasks(student_id,title,course,deadline,priority) VALUES(?,?,?,?,?)"
);

$stmt->bind_param("issss",$student_id,$title,$course,$deadline,$priority);

$stmt->execute();

/* activity log */

$activity = "Created task: " . $title;

$log = $conn->prepare("INSERT INTO activities(student_id,message) VALUES(?,?)");
$log->bind_param("is",$student_id,$activity);
$log->execute();

header("Location: ../tasks.php");
exit();

header("Location: ../tasks.php");
exit();

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Task</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

<form method="POST" class="bg-white p-8 shadow rounded w-96">

<h2 class="text-2xl font-bold mb-4">Add Task</h2>

<input
type="text"
name="title"
placeholder="Task Title"
required
class="border p-2 w-full mb-3 rounded">

<input
type="text"
name="course"
placeholder="Course"
required
class="border p-2 w-full mb-3 rounded">

<input
type="date"
name="deadline"
required
class="border p-2 w-full mb-3 rounded">

<select name="priority" class="border p-2 w-full mb-4 rounded">

<option value="Low">Low</option>
<option value="Medium">Medium</option>
<option value="High">High</option>

</select>

<button
name="add_task"
class="bg-blue-600 text-white w-full p-2 rounded hover:bg-blue-700">

Add Task

</button>

</form>

</body>
</html>