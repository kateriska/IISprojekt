<?php
$id = $_POST['id'];
if(!isset($_POST['submit_reject'])){
  header("Location: ./index.php?id=$id");
  exit();
}

session_start();

require_once("dbh.php");

$query = "DELETE FROM ke_schvaleni_kurz WHERE Kurzy_ID='$id'";
if( !mysqli_query($db, $query) ){
  header("Location: ./course_draft.php?id=$id&err=or");
  exit();
}

if(isset($_POST['delete_original'])){
  $query = "DELETE FROM kurzy WHERE Kurzy_ID='$id'";
  if( !mysqli_query($db, $query) ){
    header("Location: ./course_draft.php?id=$id&err=or");
    exit();
  }
}

header("Location: ./courses.php?succ=rejected");
exit();
?>