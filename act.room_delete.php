<?php
$id = $_POST['id'];
if(!isset($_POST['room_delete_submit'])){
  header("Location: ./room.php?id=$id");
  exit();
}

require_once("dbh.php");

$query = "DELETE FROM mistnosti WHERE Mistnosti_ID='$id'";

if(mysqli_query($db, $query)){
  header("Location: ./rooms.php?succ=deleted");
}else{
  header("Location: ./room.php?id=$id&err=or");
}
exit();
?>