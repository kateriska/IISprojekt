<?php
if(isset($_POST['submit_login'])){

  require_once("dbh.php");
  require_once("fn.pwd_hash.php");

  $mail = $_POST['mail'];
  $pwd = $_POST['pwd']; 

  

   if(empty($mail) || empty($pwd)){
     header("Location: ./index.php?error=emptyFields&mail=" . $mail);
     exit();
   }
   else{

    $query = "SELECT * FROM uzivatele WHERE email='$mail'";
    $result = mysqli_query($db, $query);
    if($result === FALSE){
      //SQL error
      header("Location: ./index.php?error=sql" . $mail);
      mysqli_free_result($result);exit();
    }

    $row = mysqli_fetch_assoc($result);

    $pwd_check = pwd_verify($pwd, $row['heslo']);
    if($pwd_check === FALSE){
      //wrong pwd
      header("Location: ./index.php?err=pwd&mail=$mail" );
      mysqli_free_result($result); exit();
    } else if($pwd_check === TRUE){
      header("Location: ./index.php?success=login");
      session_start();
      $_SESSION['user_id'] = $row['Uzivatele_ID'];
      $_SESSION['role'] = $row['role'];
      $_SESSION['mail'] = $row['email'];
      mysqli_free_result($result);exit();
    } else{
      //some other problem
      header("Location: ./index.php?err=boolError&mail=$mail");
      mysqli_free_result($result);exit();
    }
   }
}
else{
  header("Location: ./index.php");
  exit();
}



?>