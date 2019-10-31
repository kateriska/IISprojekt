<?php
if(!isset($_POST['event_create_submit'])){
  header("Location: ./event_create.php?inv=alid");
  exit();
}



//TODO



$id = $_POST['id'];
$name = $_POST['name'];
$type = $_POST['type'];
$price = $_POST['price'];
$garant = $_POST['garant'];
$dep_head = $_POST['dep_head'];
$desc = $_POST['description'];


if($price == ''){
  $price = '0';
}

if( $id == '' || $name == '' || $type == ''  || $price < 0 || $garant == '' || $dep_head == '' || $desc == '' ){
  header("Location: ./course_create.php?err=empty_or_inv_fields");
  exit();
}

require_once("dbh.php");
session_start();
$my_id = $_SESSION['user_id'];


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
exit();
?>