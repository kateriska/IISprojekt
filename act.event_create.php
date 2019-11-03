<?php
function room_event($id, $type, $date, $time, $duration, $lector, $desc, $room, $db){
  
  $start_time = date('H.i', strtotime($time));
  $check_end = TRUE;
  $duration = ceil($duration);

  if( $duration <= '0' ){
    $check_end = FALSE;
  } else if($duration == '1'){
    $end_time = date('H.i', strtotime($time . ' + 1 minute'));
  }else{
    $end_time = date('H.i', strtotime($time . " + $duration minutes"));
  }




  echo("$date $time $end_time");
  $query = "SELECT datum, cas, mistnost_ID, Kurzy_ID, typ_termin FROM terminy WHERE mistnost_ID='$room' AND datum='$date'";
  $result = mysqli_query($db, $query);
  if($result == FALSE){
    header("Location: ./event_create.php?id=$id&err=sql1");
    exit();
  }
  $isfree = TRUE;

  while( $row = mysqli_fetch_assoc($result) ){
    //kontrola prekryvani udalosti
     print_r($row);
    
  }

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