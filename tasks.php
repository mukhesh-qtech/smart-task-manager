<?php
include("includes/auth_check.php");
include("config/database.php");

$student_id = $_SESSION['student_id'];

$filter = isset($_GET['filter']) ? $_GET['filter'] : "all";
$search = isset($_GET['search']) ? $_GET['search'] : "";

$query = "SELECT * FROM tasks WHERE student_id=?";
$params = [$student_id];
$types = "i";

if($filter=="pending"){
$query .= " AND status='Pending'";
}
elseif($filter=="completed"){
$query .= " AND status='Completed'";
}
elseif($filter=="urgent"){
$query .= " AND deadline <= DATE_ADD(CURDATE(), INTERVAL 1 DAY) AND status='Pending'";
}

if($search!=""){
$query .= " AND title LIKE ?";
$params[]="%".$search."%";
$types.="s";
}

$query .= " ORDER BY deadline ASC";

$stmt = $conn->prepare($query);
$stmt->bind_param($types,...$params);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html>
<head>

<title>Tasks</title>

<script src="https://cdn.tailwindcss.com"></script>

<style>

body{
background: linear-gradient(135deg,#0f172a,#1e293b);
min-height:100vh;
}

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

<h2 class="text-2xl font-bold mb-8">Task Manager</h2>

<ul class="space-y-4">

<li><a href="dashboard.php">Dashboard</a></li>
<li><a href="tasks.php" class="text-blue-400">Tasks</a></li>
<li><a href="calendar.php">Calendar</a></li>
<li><a href="auth/logout.php" class="text-red-400">Logout</a></li>

</ul>

</div>

<!-- MAIN -->

<div class="flex-1 p-10">

<h1 class="text-3xl font-bold mb-6">My Tasks</h1>

<!-- FILTERS -->

<div class="flex gap-3 mb-6">

<a href="tasks.php" class="bg-gray-500 px-3 py-1 rounded">All</a>

<a href="tasks.php?filter=pending"
class="bg-yellow-500 px-3 py-1 rounded">Pending</a>

<a href="tasks.php?filter=completed"
class="bg-green-500 px-3 py-1 rounded">Completed</a>

<a href="tasks.php?filter=urgent"
class="bg-red-500 px-3 py-1 rounded">Urgent</a>

</div>

<!-- SEARCH -->

<div class="flex justify-between mb-6">

<form method="GET">

<input
type="text"
name="search"
placeholder="Search tasks..."
value="<?php echo $search ?>"
class="p-2 rounded text-black">

<button class="bg-blue-500 px-3 py-2 rounded">Search</button>

</form>

<a href="tasks/add_task.php"
class="bg-green-500 px-4 py-2 rounded">
Add Task
</a>

</div>

<!-- TABLE -->

<div class="glass p-6 rounded-xl">

<table class="w-full">

<tr class="border-b border-white/20">

<th class="p-3 text-left">Title</th>
<th>Course</th>
<th>Deadline</th>
<th>Priority</th>
<th>Status</th>
<th>Actions</th>

</tr>

<?php while($row=$result->fetch_assoc()) { ?>

<tr class="border-b border-white/10">

<td class="p-3"><?php echo $row['title']; ?></td>

<td><?php echo $row['course']; ?></td>

<td><?php echo $row['deadline']; ?></td>

<td><?php echo $row['priority']; ?></td>

<td>

<?php
if($row['status']=="Completed"){
echo "<span class='text-green-400'>Completed</span>";
}else{
echo "<span class='text-yellow-300'>Pending</span>";
}
?>

</td>

<td class="space-x-2">

<button
onclick="openEditModal(
<?php echo $row['id']; ?>,
'<?php echo addslashes($row['title']); ?>',
'<?php echo addslashes($row['course']); ?>',
'<?php echo $row['deadline']; ?>',
'<?php echo $row['priority']; ?>'
)"
class="bg-yellow-500 px-2 py-1 rounded text-sm">

Edit

</button>

<button
onclick="completeTask(<?php echo $row['id']; ?>,this)"
class="bg-blue-500 px-2 py-1 rounded text-sm">

Complete

</button>

<button
onclick="deleteTask(<?php echo $row['id']; ?>,this)"
class="bg-red-500 px-2 py-1 rounded text-sm">

Delete

</button>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>

<!-- EDIT MODAL -->

<div id="editModal"
class="hidden fixed inset-0 bg-black/60 flex items-center justify-center">

<div class="glass p-6 rounded-xl w-96">

<h2 class="text-xl font-bold mb-4">Edit Task</h2>

<input id="editTitle"
class="w-full p-2 mb-2 rounded text-black">

<input id="editCourse"
class="w-full p-2 mb-2 rounded text-black">

<input id="editDeadline"
type="date"
class="w-full p-2 mb-2 rounded text-black">

<select id="editPriority"
class="w-full p-2 mb-3 rounded text-black">

<option>Low</option>
<option>Medium</option>
<option>High</option>

</select>

<div class="flex gap-2">

<button onclick="saveTask()"
class="bg-green-500 px-4 py-2 rounded">
Save
</button>

<button onclick="closeEditModal()"
class="bg-red-500 px-4 py-2 rounded">
Cancel
</button>

</div>

</div>

</div>

<script>

let editTaskId = null;

function openEditModal(id,title,course,deadline,priority){

editTaskId=id;

document.getElementById("editTitle").value=title;
document.getElementById("editCourse").value=course;
document.getElementById("editDeadline").value=deadline;
document.getElementById("editPriority").value=priority;

document.getElementById("editModal").classList.remove("hidden");

}

function closeEditModal(){
document.getElementById("editModal").classList.add("hidden");
}

function saveTask(){

let title = document.getElementById("editTitle").value;
let course = document.getElementById("editCourse").value;
let deadline = document.getElementById("editDeadline").value;
let priority = document.getElementById("editPriority").value;

let params = new URLSearchParams();

params.append("id", editTaskId);
params.append("title", title);
params.append("course", course);
params.append("deadline", deadline);
params.append("priority", priority);

fetch("tasks/update_task.php",{
method:"POST",
body:params
})
.then(res=>res.text())
.then(data=>{

console.log(data);

if(data.trim()=="success"){
location.reload();
}else{
alert("Update failed");
}

});

}

</script>

</body>
</html>