<?php

function room_event($id, $date, $time, $duration, $room, $db){
  
  $start_timestamp = date('Y-m-d H.i', strtotime($date.$time));
  $duration = ceil($duration);

  if( $duration <= '0' ){
    $end_timestamp = $start_timestamp;
  } else if($duration == '1'){
    $end_timestamp = date('Y-m-d H.i', strtotime($date.$time . ' + 1 minute'));
  }else{
    $end_timestamp = date('Y-m-d H.i', strtotime($date.$time . " + $duration minutes"));
  }

  $query = "SELECT datum, cas, doba_trvani, Kurzy_ID, typ_termin FROM terminy WHERE mistnosti_ID='$room'";
  echo($query);
  $result = mysqli_query($db, $query);
  if($result == FALSE){
    /*header("Location: ./event_create.php?id=$id&err=sql1");
    exit()*/;
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

    if($r_start_ts <= $start_timestamp && $r_end_ts <= $start_timestamp){
      break;
    }else if($r_start_ts >= $end_timestamp && $r_end_ts >= $end_timestamp){
      break; 
    }else{
      header("Location: ./event_create.php?id=$id&err=clash&course=" .$row['Kurzy_ID']. "&typ_termin=" .$row['typ_termin']);
    exit();
    }
  }
  return TRUE;
}

function noroom_event($id, $type, $date, $time, $duration, $lector, $desc, $db){

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
  room_event($id, $type, $date, $time, $duration, $lector, $desc, $room, $db);
}






/*

$query = "INSERT INTO kurzy (Kurzy_ID, nazev, popis, typ, cena, garant_ID, vedouci_ID) 
VALUES ('$id', 'Nový kurz, èeká na schválení', '', '', '-1', '$garant', '$dep_head')";
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