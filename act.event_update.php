<?php
$id = $_POST['id'];
$date = $_POST['date'];
$time = $_POST['time'];
$room = $_POST['room'];

if(!isset($_POST['event_update_submit'])){
  header("Location: ./event.php?id=$id&d=$date&t=$time&r=$room");
  exit();
}

$type = $_POST['type'];
$duration = $_POST['duration'];
$lector = $_POST['lector'];
$desc = $_POST['description'];
$prev_room = $_POST['prev_room'];
$prev_date = $_POST['prev_date'];
$prev_time = $_POST['prev_time'];


if( $id == ''|| $date == '' || $time == ''|| ($duration < '0' && $duration != '') ){
  header("Location: ./room.php?id=$id&err=empty_or_inv_fields");
  exit();
}

require_once("dbh.php");

//todo delete, todo insert

exit();
?>

