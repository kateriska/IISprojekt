<?php
$id = $_POST['id'];
if(!isset($_POST['submit_reject'])){
  header("Location: ./index.php?id=$id");
  exit();
}

session_start();

require_once("dbh.php");

$query = "DELETE FROM ke_schvaleni_kurz WHERE Kurzy_ID='$id'";

if(mysqli_query($db, $query)){
  header("Location: ./index.php?succ=deleted");
}else{
  header("Location: ./course_draft.php?id=$id&err=or");
}
exit();
?>