<?php
$id = $_POST['id'];
if(!isset($_POST['user_delete_submit'])){
  header("Location: ./user.php?id=$id");
  exit();
}

session_start();

if( $id == $_SESSION['user_id'] ){
  header("Location: ./user.php?id=$id&err=no_selfdelete");
  exit();
}

require_once("dbh.php");

$query = "DELETE FROM uzivatele WHERE Uzivatele_ID='$id'";

if(mysqli_query($db, $query)){
  header("Location: ./users.php?succ=deleted");
}else{
  header("Location: ./user_update.php?id=$id&err=or");
}
exit();
?>