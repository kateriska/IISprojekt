<?php

$id = $_POST['id'];
$date = $_POST['date'];
$time = $_POST['time'];
$room = $_POST['room'];

if(!isset($_POST['submit_delete_event'])){
  header("Location: ./event.php?id=$id&d=$date&t=$time&r=$room");
  exit();
}

require_once("dbh.php");

$query = "DELETE FROM terminy WHERE Kurzy_ID='$id' AND datum='$date' AND cas='$time' AND mistnost_ID='$room'";

if(mysqli_query($db, $query)){
  header("Location: ./course.php?id=$id&succ=deleted");
}else{
  header("Location: ./course.php?id=$id&d=$date&t=$time&r=$room&err=or");
}
exit();
?>