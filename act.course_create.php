<?php
if(!isset($_POST['course_create_submit'])){
  header("Location: ./course_create.php?inv=alid");
  exit();
}

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

if( $id == '' || $name == ''){
  header("Location: ./course_create.php?err=empty_fields&id=$id&name=$name&type=$type&price=$price&garant=$garant&dep_head=$dep_head&desc=$desc");
  exit();
}

if($price < 0 ){
  header("Location: ./course_create.php?err=inv_price&id=$id&name=$name&type=$type&garant=$garant&dep_head=$dep_head&desc=$desc");
  exit();
}

require_once("dbh.php");
session_start();
$my_id = $_SESSION['user_id'];


$query = "INSERT INTO kurzy (Kurzy_ID, nazev, popis, typ, cena, garant_ID, vedouci_ID) 
VALUES ('$id', 'Nov� kurz, �ek� na schv�len�', '', '', '-1', '$garant', '$dep_head')";
if( !mysqli_query($db, $query) ){
  header("Location: ./course_create.php?err=id_taken&name=$name&type=$type&price=$price&garant=$garant&dep_head=$dep_head&desc=$desc");
  exit();
}

$query = "INSERT INTO ke_schvaleni_kurz (Kurzy_ID, nazev, popis, typ, cena, garant_ID, vedouci_ID, zadatel_ID) 
VALUES ('$id', '$name', '$desc', '$type', '$price', '$garant', '$dep_head', '$my_id')";
if( !mysqli_query($db, $query) ){
  header("Location: ./course_create.php?err=id_taken&name=$name&type=$type&price=$price&garant=$garant&dep_head=$dep_head&desc=$desc");
}else{
  header("Location: ./courses.php?succ=created");
}
exit();
?>