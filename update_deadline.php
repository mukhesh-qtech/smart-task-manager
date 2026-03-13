<?php

include("includes/auth_check.php");
include("config/database.php");

if(isset($_POST['id']) && isset($_POST['date'])){

$id = $_POST['id'];
$date = $_POST['date'];

$stmt = $conn->prepare("UPDATE tasks SET deadline=? WHERE id=?");

$stmt->bind_param("si",$date,$id);

if($stmt->execute()){
echo "updated";
}else{
echo "error";
}

}else{
echo "missing data";
}

?>