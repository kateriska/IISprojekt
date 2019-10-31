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

if( $id == '' || $name == '' || $type == ''  || $price < 0 || $garant == '' || $dep_head == '' || $desc == '' ){
  header("Location: ./course_create.php?err=empty_or_inv_fields");
  exit();
}

require_once("dbh.php");

$query = "INSERT INTO ke_schvaleni_kurz (jmeno, prijmeni, heslo, role, email) VALUES ('$firstname', '$lastname', '$pwd_hash', '$role', '$mail')";

if(mysqli_query($db, $query)){
  header("Location: ./users.php?succ=created");
}else{
  header("Location: ./user_create.php?err=mail_taken");
}
exit();
?>