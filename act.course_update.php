<?php
$id = $_POST['id'];
if(!isset($_POST['course_edit_submit'])){
  header("Location: ./course.php?id=$id");
  exit();
}

$name = $_POST['name'];
$type = $_POST['type'];
$garant = $_POST['garant'];
$dep_head = $_POST['dep_head'];
$price = $_POST['price'];
$desc = $_POST['desc'];
$id = $_POST['id'];
$draft = $_POST['draftval'];

if(isset($_POST['dep_head'])){
  $dep_head_text = "vedouci_ID='$dep_head',";
}else{
  $dep_head_text = '';
}

session_start();
$me = $_SESSION['user_id'];
if($draft == 0){
  $query = "INSERT INTO ke_schvaleni_kurz (Kurzy_ID, nazev, popis, typ, cena, garant_ID, vedouci_ID, zadatel_ID)
  VALUES ('$id', '$name', '$desc', '$type', '$price', '$garant', '$dep_head', '$me')";
}else{
  $query = "UPDATE ke_schvaleni_kurz SET nazev='$name', popis='$desc', typ='$type', cena='$price', garant_ID='$garant', $dep_head_text zadatel_ID='$me' WHERE Kurzy_ID='$id'";
}
//echo($query);

require_once("dbh.php");


if(mysqli_query($db, $query)){
  header("Location: ./course.php?id=$id&succ=ok_wait_for_approval");
}else{
  header("Location: ./course.php?id=$id&err=update_err");
}
exit();

?>