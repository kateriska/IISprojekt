<?php
if(!isset($_POST['room_create_submit'])){
  header("Location: ./room_create.php?inv=alid");
  exit();
}

$id = strtoupper($_POST['room_id']);
$address = $_POST['address'];
$type = $_POST['type'];
$capacity = $_POST['capacity'];

if( $id == '' || $capacity == '' ){
  header("Location: ./room_create.php?err=empty_fields");
  exit();
}

require_once("dbh.php");

$query = "INSERT INTO mistnosti (Mistnosti_ID, adresa, typ, kapacita) VALUES ('$id', '$address', '$type', '$capacity');";

if(mysqli_query($db, $query)){
  header("Location: ./rooms.php?succ=created");
}else{
  header("Location: ./room_create.php?err=id_taken?id=$id&add=$address&type=$type&cap=$capacity");
}
exit();
?>