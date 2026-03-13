<?php
session_start();
include("../config/database.php");

if(isset($_POST['login'])){

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM students WHERE email=?");
$stmt->bind_param("s",$email);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if($user && password_verify($password,$user['password'])){

$_SESSION['student_id']=$user['id'];
$_SESSION['student_name']=$user['name'];

header("Location: ../dashboard.php");
exit();

}

$error="Invalid email or password";

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Login</title>

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
Student Task Manager
</h1>

<?php if(isset($error)){ ?>
<p class="text-red-400 mb-3"><?php echo $error; ?></p>
<?php } ?>

<form method="POST">

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
name="login"
class="w-full bg-blue-500 p-2 rounded hover:bg-blue-600">

Login

</button>

</form>

<p class="text-sm mt-4 text-center">

Don't have an account?

<a href="register.php" class="text-blue-400">
Register
</a>

</p>

</div>

</body>
</html>