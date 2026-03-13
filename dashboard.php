<?php
include("includes/auth_check.php");
include("config/database.php");

$student_id = $_SESSION['student_id'];

/* stats */

$total = $conn->query(
"SELECT COUNT(*) as count FROM tasks WHERE student_id=$student_id"
)->fetch_assoc()['count'];

$completed = $conn->query(
"SELECT COUNT(*) as count FROM tasks WHERE student_id=$student_id AND status='Completed'"
)->fetch_assoc()['count'];

$pending = $conn->query(
"SELECT COUNT(*) as count FROM tasks WHERE student_id=$student_id AND status='Pending'"
)->fetch_assoc()['count'];

$urgent = $conn->query(
"SELECT COUNT(*) as count FROM tasks 
WHERE student_id=$student_id 
AND deadline <= DATE_ADD(CURDATE(), INTERVAL 1 DAY)
AND status='Pending'"
)->fetch_assoc()['count'];

$progress = 0;

if($total > 0){
$progress = round(($completed/$total)*100);
}

/* activity feed */

$activity_stmt = $conn->prepare(
"SELECT message, created_at 
FROM activities 
WHERE student_id=? 
ORDER BY created_at DESC 
LIMIT 5"
);

$activity_stmt->bind_param("i",$student_id);
$activity_stmt->execute();

$activities = $activity_stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>

<style>

body{
background: linear-gradient(135deg,#0f172a,#1e293b);
min-height:100vh;
}

/* glass effect */

.glass{
background: rgba(255,255,255,0.1);
backdrop-filter: blur(10px);
border:1px solid rgba(255,255,255,0.2);
}

</style>

</head>

<body class="text-white">

<div class="flex">

<!-- SIDEBAR -->

<div class="w-64 min-h-screen bg-black/40 backdrop-blur-lg p-6">

<h2 class="text-2xl font-bold mb-8">
Task Manager
</h2>

<ul class="space-y-4">

<li>
<a href="dashboard.php" class="block hover:text-blue-400">
Dashboard
</a>
</li>

<li>
<a href="tasks.php" class="block hover:text-blue-400">
Tasks
</a>
</li>

<li>
<a href="calendar.php">Calendar</a>
</li>

<li>
<a href="auth/logout.php" class="block text-red-400">
Logout
</a>
</li>

</ul>

</div>

<!-- MAIN CONTENT -->

<div class="flex-1 p-10">

<h1 class="text-3xl font-bold mb-8">
Welcome <?php echo $_SESSION['student_name']; ?>
</h1>

<!-- STAT CARDS -->

<div class="grid grid-cols-4 gap-6">

<div class="glass p-6 rounded-xl shadow-lg">
<p class="text-gray-300">Total Tasks</p>
<h2 class="text-3xl font-bold"><?php echo $total ?></h2>
</div>

<div class="glass p-6 rounded-xl shadow-lg">
<p class="text-gray-300">Completed</p>
<h2 class="text-3xl font-bold text-green-400">
<?php echo $completed ?>
</h2>
</div>

<div class="glass p-6 rounded-xl shadow-lg">
<p class="text-gray-300">Pending</p>
<h2 class="text-3xl font-bold text-yellow-400">
<?php echo $pending ?>
</h2>
</div>

<div class="glass p-6 rounded-xl shadow-lg">
<p class="text-gray-300">Urgent</p>
<h2 class="text-3xl font-bold text-red-400">
<?php echo $urgent ?>
</h2>
</div>

</div>

<!-- PROGRESS -->

<div class="glass mt-10 p-6 rounded-xl">

<p class="mb-3 font-semibold">Task Completion Progress</p>

<div class="w-full bg-white/20 rounded">

<div
class="bg-green-400 text-black text-center p-1 rounded"
style="width: <?php echo $progress ?>%">

<?php echo $progress ?>%

</div>

</div>

</div>

<!-- ACTIVITY FEED -->

<div class="glass mt-10 p-6 rounded-xl">

<h2 class="text-xl font-bold mb-4">Recent Activity</h2>

<ul class="space-y-3">

<?php while($act=$activities->fetch_assoc()) { ?>

<li class="border-b border-white/20 pb-2">

<?php echo $act['message']; ?>

<span class="text-sm text-gray-300 ml-2">
<?php echo $act['created_at']; ?>
</span>

</li>

<?php } ?>

</ul>

</div>

</div>

</div>

</body>
</html>