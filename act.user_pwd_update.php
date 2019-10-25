<?php
$id = $_POST['id'];
if(!isset($_POST['user_set_pwd_submit'])){
  header("Location: ./user.php?id=$id");
  exit();
}

$pwd = $_POST['pwd'];

if( $pwd == '' ){
  header("Location: ./user.php?id=$id&err=empty_field");
  exit();
}

require_once("fn.pwd_hash.php");
require_once("dbh.php");

$pwd_hash = pwd_crypt($pwd);

$query = "UPDATE uzivatele SET heslo='$pwd_hash' WHERE Uzivatele_ID='$id'";

if(mysqli_query($db, $query)){
  header("Location: ./user.php?id=$id&succ=created");
}else{
  header("Location: ./user_create.php?id=$id&err=or");
}
exit();
?>