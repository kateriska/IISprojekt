<?php
$id = $_POST['id'];
if(!isset($_POST['user_edit_submit'])){
  header("Location: ./room.php?id=$id");
  exit();
}

$address = $_POST['address'];
$type = $_POST['type'];
$capacity = $_POST['capacity'];

if( $address == '' || $type == '' || $capacity == '' ){
  header("Location: ./room.php?id=$id&err=empty_fields");
  exit();
}

require_once("dbh.php");

$query = "UPDATE mistnosti SET adresa='$address', typ='$type', kapacita='$capacity' WHERE Mistnosti_ID='$id'";

if(mysqli_query($db, $query)){
  header("Location: ./room.php?id=$id&succ=created");
}else{
  header("Location: ./room.php?id=$id&err=update_err");
}
exit();
?>