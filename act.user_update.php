<?php
$id = $_POST['id'];
if(!isset($_POST['user_edit_submit'])){
  header("Location: ./user.php?id=$id");
  exit();
}

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$role = $_POST['role'];
$mail = $_POST['mail'];

if( $firstname == '' || $lastname == '' || $mail == '' ){
  header("Location: ./user.php?id=$id&err=empty_fields");
  exit();
}

require_once("dbh.php");

$query = "UPDATE uzivatele SET jmeno='$firstname', prijmeni='$lastname', role='$role', email='$mail' WHERE Uzivatele_ID='$id'";

if(mysqli_query($db, $query)){
  header("Location: ./user.php?id=$id&succ=created");
}else{
  header("Location: ./user.php?id=$id&err=mail_taken");
}
exit();
?>