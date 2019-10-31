<?php
$id = $_POST['id'];
if(!isset($_POST['submit_approve'])){
  header("Location: ./index.php?id=$id");
  exit();
}

session_start();

require_once("dbh.php");

$query = "SELECT nazev, popis, typ, cena, garant_ID FROM ke_schvaleni_kurz WHERE Kurzy_ID='$id'";
$result = mysqli_query($db, $query); 

if($result === FALSE){ //SQL ERR
  header("Location: ./course_draft.php?id=$id&err=or");
  exit();
}

$row = mysqli_fetch_assoc($result);
if(!$row){
  header("Location: ./course_draft.php?id=$id&err=not_found");
  exit();
}

$name = $row['nazev'];
$desc = $row['popis'];
$type = $row['typ'];
$price = $row['cena'];
$garant = $row['garant_ID'];

$query = "UPDATE kurzy SET nazev='$name', popis='$desc', typ='$type', cena='$price', garant_ID='$garant' WHERE Kurzy_ID='$id'";
$result = mysqli_query($db, $query); 
if($result === FALSE){ //SQL ERR
  header("Location: ./course_draft.php?id=$id&err=or2");
  exit();
}

$query = "DELETE FROM ke_schvaleni_kurz WHERE Kurzy_ID='$id'";
if(mysqli_query($db, $query)){
  header("Location: ./index.php?succ=updated");
}else{
  header("Location: ./course_draft.php?id=$id&err=or3");
}
exit();
?>