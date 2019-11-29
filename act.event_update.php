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

if(isset($_FILES['input_file'])){

   $errors= array();
   $file_name = $_FILES['input_file']['name'];
   $file_size = $_FILES['input_file']['size'];
   $file_tmp = $_FILES['input_file']['tmp_name'];
   $file_type = $_FILES['input_file']['type'];
   $file_ext=strtolower(end(explode('.',$_FILES['input_file']['name'])));

   if($file_size > 52428800) {
      $errors[]='Chyba - Soubor je vìt¹í jak 50 MB!';
   }

   if(empty($errors)==true) {
      move_uploaded_file($file_tmp,"event_files/".$file_name);
      chmod("event_files/".$file_name, 644);
      $file_upload = true;
   }else{
      print_r($errors);
   }
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

if ($file_upload == true)
{
  $query = "INSERT INTO soubory (Kurzy_ID, datum, cas, mistnost_ID, nazev_souboru)
          VALUES ('$id', '$date', '$time', '$room', '$file_name')";
  $result = mysqli_query($db, $query);
  if($result == FALSE){
    echo "Chyba vkladani souboru";
  }

}
header("Location: ./course.php?id=$id&succ=edited");
exit();


?>
