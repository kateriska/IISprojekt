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
  header("Location: ./event.php?id=$id&d=$date&t=$time&r=$room&err=empty_fields");
  exit();
}

require_once("dbh.php");

$query = "DELETE FROM terminy WHERE Kurzy_ID='$id' AND datum='$prev_date' AND cas='$prev_time' AND mistnost_ID='$prev_room'";
$result = mysqli_query($db, $query);
if($result == FALSE){
  echo($query);
  header("Location: ./event.php?id=$id&d=$prev_date&t=$prev_time&r=$prev_room&err=sql_del");
  exit();
}

$query = "INSERT INTO terminy (Kurzy_ID, datum, cas, mistnost_ID, lektor_ID, popis, typ_termin, doba_trvani) 
          VALUES ('$id', '$date', '$time', '$room', '$lector', '$desc', '$type', '$duration')";
$result = mysqli_query($db, $query);
if($result == FALSE){
  echo($query);
  $query = "INSERT INTO terminy (Kurzy_ID, datum, cas, mistnost_ID, lektor_ID, popis, typ_termin, doba_trvani) 
          VALUES ('$id', '$prev_date', '$prev_time', '$prev_room', '$lector', '$desc', '$type', '$duration')";
  $result = mysqli_query($db, $query);
  if($result == FALSE){
    echo($query . " PRUSVIH");
    header("Location: ./event.php?id=$id&d=$prev_date&t=$prev_time&r=$prev_room&err=sql_ins");
    exit();
  }
  
  header("Location: ./event.php?id=$id&d=$prev_date&t=$prev_time&r=$prev_room&err=room_occupied");
  exit();
}







exit();
?>

