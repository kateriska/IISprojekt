<?php

function room_event($id, $date, $time, $duration, $room, $db, $desc, $type, $lector){
  
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
    header("Location: ./event_create.php?id=$id&err=sql1");
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
      header("Location: ./event_create.php?id=$id&err=clash&course=" .$row['Kurzy_ID']. "&typ_termin=" .$row['typ_termin']);
      exit();
    }
  }

  $query = "INSERT INTO terminy (Kurzy_ID, datum, cas, mistnost_ID, popis, typ_termin, doba_trvani, lektor_ID) 
  VALUES ('$id', '$date', '$time', '$room', '$desc', '$type', '$duration', '$lector')";
  $result = mysqli_query($db, $query);
  if($result == FALSE){
    echo("$query");
    //header("Location: ./event_create.php?id=$id&err=sql2");
  }else{
    header("Location: ./course.php?id=$id&succ=created");
  }
}

function noroom_event($id, $type, $date, $time, $duration, $lector, $desc, $db){
  $query = "SELECT datum, cas, doba_trvani, Kurzy_ID, typ_termin FROM terminy WHERE mistnost_ID='$room' AND datum='$date'";
  $result = mysqli_query($db, $query);
  if($result == FALSE){
    header("Location: ./event_create.php?id=$id&err=sql1n");
    exit();
  }

  $maxtime = 0;

  while( $row = mysqli_fetch_assoc($result) ){
    $hr_min = substr($row['cas'], 0, 5);
    if($hr_min == $time){
      $r_max = explode(".", $row['cas']);
      $r_max = $r_max[1];
      if($r_max > $maxtime){
        $maxtime = $r_max + 1;
      }
    }
  }

  $time = $time . ":00.". str_pad($maxtime, 6, " ", STR_PAD_LEFT);

  echo($time);
}




if(!isset($_POST['event_create_submit'])){
  header("Location: ./event_create.php?inv=alid");
  exit();
}

$id = $_POST['id'];
$type = $_POST['type'];
$date = $_POST['date'];
$time = $_POST['time'];
$duration = $_POST['duration'];
$room = $_POST['room'];
$lector = $_POST['lector'];
$desc = $_POST['description'];

if( $id == '' || $type == '' || $date == ''  || ($duration < '0' && $duration != '') || $lector == '' || $desc == '' ){
  header("Location: ./course_create.php?err=empty_or_inv_fields");
  exit();
}

require_once("dbh.php");
if( $room == '' ){
  noroom_event($id, $type, $date, $time, $duration, $lector, $desc, $db);
}else{
  room_event($id, $date, $time, $duration, $room, $db, $desc, $type, $lector);
}






/*

$query = "INSERT INTO kurzy (Kurzy_ID, nazev, popis, typ, cena, garant_ID, vedouci_ID) 
VALUES ('$id', 'Nov� kurz, �ek� na schv�len�', '', '', '-1', '$garant', '$dep_head')";
if( !mysqli_query($db, $query) ){
  header("Location: ./course_create.php?err=id_taken");
  exit();
}

$query = "INSERT INTO ke_schvaleni_kurz (Kurzy_ID, nazev, popis, typ, cena, garant_ID, vedouci_ID, zadatel_ID) 
VALUES ('$id', '$name', '$desc', '$type', '$price', '$garant', '$dep_head', '$my_id')";
if( !mysqli_query($db, $query) ){
  header("Location: ./course_create.php?err=id_taken");
}else{
  header("Location: ./courses.php?succ=created");
}
exit();*/
?>