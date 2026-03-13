<?php
include("../config/database.php");

if(isset($_POST['register'])){

$name=$_POST['name'];
$email=$_POST['email'];
$password=password_hash($_POST['password'],PASSWORD_DEFAULT);

$stmt=$conn->prepare(
"INSERT INTO students(name,email,password) VALUES(?,?,?)"
);

$stmt->bind_param("sss",$name,$email,$password);

$stmt->execute();

header("Location: login.php");
exit();

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Register</title>

<script src="https://cdn.tailwindcss.com"></script>

<style>

body{
background: linear-gradient(135deg,#0f172a,#1e293b);
height:100vh;
display:flex;
align-items:center;
justify-content:center;
}

.glass{
background: rgba(255,255,255,0.1);
backdrop-filter: blur(12px);
border:1px solid rgba(255,255,255,0.2);
}

</style>

</head>

<body class="text-white">

<div class="glass p-10 rounded-xl w-96 shadow-lg">

<h1 class="text-2xl font-bold mb-6 text-center">
Create Account
</h1>

<form method="POST">

<input
type="text"
name="name"
placeholder="Full Name"
required
class="w-full p-2 mb-3 rounded text-black">

<input
type="email"
name="email"
placeholder="Email"
required
class="w-full p-2 mb-3 rounded text-black">

<input
type="password"
name="password"
placeholder="Password"
required
class="w-full p-2 mb-4 rounded text-black">

<button
name="register"
class="w-full bg-green-500 p-2 rounded hover:bg-green-600">

Register

</button>

</form>

<p class="text-sm mt-4 text-center">

Already have an account?

<a href="login.php" class="text-blue-400">
Login
</a>

</p>

</div>

</body>
</html>