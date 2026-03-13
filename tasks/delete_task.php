<?php

include("../includes/auth_check.php");
include("../config/database.php");

$id = $_POST['id'];
$student_id = $_SESSION['student_id'];

$get = $conn->prepare("SELECT title FROM tasks WHERE id=?");
$get->bind_param("i",$id);
$get->execute();

$result = $get->get_result();
$task = $result->fetch_assoc();
$title = $task['title'];

$stmt = $conn->prepare("DELETE FROM tasks WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();

/* activity log */

$activity = "Deleted task: ".$title;

$log = $conn->prepare("INSERT INTO activities(student_id,message) VALUES(?,?)");
$log->bind_param("is",$student_id,$activity);
$log->execute();

echo "success";

?>