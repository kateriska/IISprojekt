<?php
if(!isset($_POST['user_create_submit'])){
  header("Location: ./user_create.php?inv=alid");
  exit();
}

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$role = $_POST['role'];
$mail = $_POST['mail'];
$pwd = $_POST['pwd'];

if( $firstname == '' || $lastname == '' || $mail == ''  || $pwd == '' ){
  header("Location: ./user_create.php?err=empty_fields");
  exit();
}

require_once("fn.pwd_hash.php");
require_once("dbh.php");

$pwd_hash = pwd_crypt($pwd);

$query = "INSERT INTO uzivatele (jmeno, prijmeni, heslo, role, email) VALUES ('$firstname', '$lastname', '$pwd_hash', '$role', '$mail');";

if(mysqli_query($db, $query)){
  header("Location: ./users.php?succ=created");
}else{
  header("Location: ./user_create.php?err=mail_taken&mail=$mail&name=$firstname&surname=$lastname&role=$role");
}
exit();
?>