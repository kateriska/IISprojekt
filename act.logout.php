<?php
if(isset($_POST['submit_logout'])){
  header("Location: ./index.php?success=logout");
      session_start();
      unset($_SESSION['user_id']);
      unset($_SESSION['role']);
      exit();
}else{
  header("Location: ./index.php");
  exit();
}
?>