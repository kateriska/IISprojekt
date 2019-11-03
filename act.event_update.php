<?php
function room_event($id, $date, $time, $duration, $room, $db, $desc, $type, $lector, $prev_date, $prev_time, $prev_room){
  
  $start_timestamp = date('Y-m-d H.i', strtotime($date.$time));
  $duration = ceil($duration);

  if( $duration <= '0' ){
    $end_timestamp = $start_timestamp;
  } else if($duration == '1'){
    $end_timestamp = date('Y-m-d H.i', strtotime($date.$time . ' + 1 minute'));
  }else{
    $end_timestamp = date('Y-m-d H.i', strtotime($date.$time . " + $duration minutes"));
  }

  $query = "SELECT datum, cas, doba_trvani, Kurzy_ID, typ_termin FROM terminy WHERE mistnost_ID='$room'";
  $result = mysqli_query($db, $query);
  if($result == FALSE){
    header("Location: ./event.php?id=$id&d=$date&t=$time&r=$room&err=sql1");
    exit();
  }
  $isfree = TRUE;

  while( $row = mysqli_fetch_assoc($result) ){
    //kontrola prekryvani udalosti
    $r_start_ts = date('Y-m-d H.i', strtotime($row['datum'].$row['cas']));
    if($row['doba_trvani'] == ''){
      $r_end_ts = $r_start_ts;
    } else if($row['doba_trvani'] == '1'){
      $r_end_ts = date('Y-m-d H.i', strtotime($row['datum'].$row['cas'] . ' + 1 minute'));
    }else{
      $r_end_ts = date('Y-m-d H.i', strtotime($row['datum'].$row['cas'] . ' + '. $row['doba_trvani'] .' minutes'));
    }

    if($r_start_ts < $start_timestamp && $r_end_ts <= $start_timestamp){
      break;
    }else if($r_start_ts >= $end_timestamp && $r_end_ts > $end_timestamp){
      break; 
    }else{
      header("Location: ./event.php?id=$id&d=$date&t=$time&r=$room&err=clash");
      exit();
    }
  }

  $query = "DELETE FROM terminy WHERE Kurzy_ID='$id' AND datum='$prev_date' AND cas='$prev_time' AND mistnost_ID='$prev_room'";
  if( !mysqli_query($db, $query)){
    header("Location: ./room.php?id=$id&err=delete_err");
    exit();
  }

  $query = "INSERT INTO terminy (Kurzy_ID, datum, cas, mistnost_ID, popis, typ_termin, doba_trvani, lektor_ID) 
  VALUES ('$id', '$date', '$time', '$room', '$desc', '$type', '$duration', '$lector')";
  $result = mysqli_query($db, $query);
  if($result == FALSE){
    header("Location: ./event.php?id=$id&d=$date&t=$time&r=$room&err=sql2");
  }else{
    header("Location: ./event.php?id=$id&d=$date&t=$time&r=$room");
  }
}

function noroom_event($id, $type, $date, $time, $duration, $lector, $desc, $db, $prev_date, $prev_time, $prev_room){
  $query = "SELECT datum, cas, doba_trvani, Kurzy_ID, typ_termin FROM terminy WHERE datum='$date' AND mistnost_ID=''";
  $result = mysqli_query($db, $query);
  if($result == FALSE){
    header("Location: ./event.php?id=$id&d=$date&t=$time&r=$room&err=sql1");
    exit();
  }

  $maxtime = 0;

  while( $row = mysqli_fetch_assoc($result) ){
    $hr_min = substr($row['cas'], 0, 5);
    if($hr_min == $time){
      $r_max = explode(".", $row['cas']);
      $r_max = $r_max[1];
      if($r_max >= $maxtime){
        $maxtime = $r_max + 1;
      }
    }
  }

  $maxtime = sprintf("%06d", $maxtime);
  $time = $time . ":00.". $maxtime;

  $query = "DELETE FROM terminy WHERE Kurzy_ID='$id' AND datum='$prev_date' AND cas='$prev_time' AND mistnost_ID='$prev_room'";
  if( !mysqli_query($db, $query)){
    header("Location: ./event.php?id=$id&d=$date&t=$time&r=$room&err=delete_err");
    exit();
  }
  $query = "INSERT INTO terminy (Kurzy_ID, datum, cas, mistnost_ID, popis, typ_termin, doba_trvani, lektor_ID) 
  VALUES ('$id', '$date', '$time', '', '$desc', '$type', '$duration', '$lector')";
  $result = mysqli_query($db, $query);
  if($result == FALSE){
    header("Location: ./event.php?id=$id&d=$date&t=$time&r=$room&err=sql2n");
  }else{
    header("Location: ./event.php?id=$id&d=$date&t=$time&r=$room");
  }
}

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
if( $room == '' ){
  noroom_event($id, $type, $date, $time, $duration, $lector, $desc, $db, $prev_date, $prev_time, $prev_room);
}else{
  room_event($id, $date, $time, $duration, $room, $db, $desc, $type, $lector, $prev_date, $prev_time, $prev_room);
}

exit();
?>

