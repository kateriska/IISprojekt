<?php
if(isset($_POST['submit_login'])){

  require_once("dbh.php");

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
      //USER NOT FOUND
      header("Location: ./index.php?error=noUser?mail=" . $mail);
      exit();
    }

    header("Location: ./index.php?succ=" . $mail . "=".$pwd."=".$result);
    exit();
    $pwd_check = password_verify($pwd, $result[0])
    /*$sql = "SELECT * FROM uzivatele WHERE email=?";
    if(!($row = mysqli_fetch_assoc($result))){
      //user not found
      header("Location: ./index.php?error=noUser?mail=" . $mail);
      exit();
    }

    $pwd_check = password_verify($pwd, $row['user_pwd']);
    if($pwd_check === false){
      //wrong pwd
      header("Location: ./index.php?error=wrongPwd?mail=" . $mail);
      exit();
    }
    else if($pwd_check === true){
      session_start();
      $_SESSION['user_id'] = $row['Uzivatele_id'];
      $_SESSION['role'] = $row['role'];

      header("Location: ./index.php?success=login");
      exit();
    }
    else{
      //some other problem
      header("Location: ./index.php?error=boolError?mail=" . $mail);
      exit();
    }*/

    // 

   }

}
else{
  header("Location: ./index.php");
  exit();
}



?>