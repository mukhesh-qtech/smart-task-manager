<?php
include("includes/auth_check.php");
include("config/database.php");

$student_id = $_SESSION['student_id'];

$result = $conn->query(
"SELECT id,title,deadline,priority,status FROM tasks WHERE student_id=$student_id"
);

$events = [];

while($row = $result->fetch_assoc()){

$events[] = [
"id"=>$row['id'],
"title"=>$row['title'],
"start"=>$row['deadline'],
"extendedProps"=>[
"priority"=>$row['priority'],
"status"=>$row['status']
]
];

}

?>

<!DOCTYPE html>
<html>
<head>

<title>Task Calendar</title>

<script src="https://cdn.tailwindcss.com"></script>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

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

<h2 class="text-2xl font-bold mb-8">
Task Manager
</h2>

<ul class="space-y-4">

<li>
<a href="dashboard.php">Dashboard</a>
</li>

<li>
<a href="tasks.php">Tasks</a>
</li>

<li>
<a href="calendar.php" class="text-blue-400">Calendar</a>
</li>

<li>
<a href="auth/logout.php" class="text-red-400">Logout</a>
</li>

</ul>

</div>

<!-- MAIN CONTENT -->

<div class="flex-1 p-10">

<h1 class="text-3xl font-bold mb-6">
Task Calendar
</h1>

<div class="glass p-6 rounded-xl">

<div id="calendar"></div>

</div>

</div>

</div>

<!-- TASK MODAL -->

<div id="taskModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center">

<div class="glass p-6 rounded-xl w-96">

<h2 id="modalTitle" class="text-xl font-bold mb-3"></h2>

<p>
Deadline: <span id="modalDate"></span>
</p>

<p>
Priority: <span id="modalPriority"></span>
</p>

<p>
Status: <span id="modalStatus"></span>
</p>

<button onclick="closeModal()" 
class="mt-4 bg-red-500 px-4 py-2 rounded">
Close
</button>

</div>

</div>

<script>

document.addEventListener('DOMContentLoaded', function() {

var calendarEl = document.getElementById('calendar');

var calendar = new FullCalendar.Calendar(calendarEl, {

initialView: 'dayGridMonth',

editable: true,

events: <?php echo json_encode($events); ?>,

eventDrop: function(info){

let taskId = info.event.id;
let newDate = info.event.startStr;

fetch("update_deadline.php",{

method:"POST",

headers:{
"Content-Type":"application/x-www-form-urlencoded"
},

body:`id=${taskId}&date=${newDate}`

})
.then(response => response.text())
.then(data => {
console.log(data);
});

},

eventClick: function(info){

let task = info.event;

document.getElementById("modalTitle").innerText = task.title;
document.getElementById("modalDate").innerText = task.startStr;
document.getElementById("modalPriority").innerText = task.extendedProps.priority;
document.getElementById("modalStatus").innerText = task.extendedProps.status;

document.getElementById("taskModal").classList.remove("hidden");

}

});

calendar.render();

});

function closeModal(){
document.getElementById("taskModal").classList.add("hidden");
}

</script>

</body>
</html>