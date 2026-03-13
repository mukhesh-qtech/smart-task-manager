<?php

include("../includes/auth_check.php");
include("../config/database.php");

if(
isset($_POST['id']) &&
isset($_POST['title']) &&
isset($_POST['course']) &&
isset($_POST['deadline']) &&
isset($_POST['priority'])
){

$id = $_POST['id'];
$title = $_POST['title'];
$course = $_POST['course'];
$deadline = $_POST['deadline'];
$priority = $_POST['priority'];

$student_id = $_SESSION['student_id'];

/* get old task name */

$get = $conn->prepare("SELECT title FROM tasks WHERE id=?");
$get->bind_param("i",$id);
$get->execute();

$result = $get->get_result();
$task = $result->fetch_assoc();

$oldTitle = $task['title'];

/* update task */

$stmt = $conn->prepare(
"UPDATE tasks SET title=?, course=?, deadline=?, priority=? WHERE id=?"
);

$stmt->bind_param("ssssi",$title,$course,$deadline,$priority,$id);
$stmt->execute();

/* activity log */

$activity = "Updated task: ".$oldTitle;

$log = $conn->prepare(
"INSERT INTO activities(student_id,message) VALUES(?,?)"
);

$log->bind_param("is",$student_id,$activity);
$log->execute();

echo "success";

}
?>