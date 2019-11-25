<html>
<head>
  <link rel="stylesheet" href="style.css">
  <?php
    require_once('fn.elements.php');
  ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>


<body>
<?php
  session_start();
  insert_login_bar();
?>

<container class="center">

<?php

function show_edit_profile_form($db){
  $id = $_SESSION['user_id'];
  $query = "SELECT jmeno, prijmeni, email FROM uzivatele WHERE Uzivatele_ID='$id'";
  $result = mysqli_query($db, $query);
  if($result === FALSE){ //SQL ERR
    echo("CHYBA SQL");return;
  }

  $row = mysqli_fetch_assoc($result);
  $firstname = htmlspecialchars($row['jmeno']);
  $lastname = htmlspecialchars($row['prijmeni']);
  $mail = htmlspecialchars($row['email']);
  echo("<h2>Upravit údaje</h2><form action=profile.php method='post'>
              Jméno:<br><input type='text' name='firstname' value='$firstname'><br>
              Pøíjmení:<br><input type='text' name='lastname' value='$lastname'><br>
              Email:<br><input type='text' name='mail' value='$mail'><br>
              <button type='submit' name='submitbutton'>Potvrdit zmìny</button>
            </form>");
}

function show_edit_pwd_form(){
  $id = $_SESSION['user_id'];
  echo("<h2>Upravit heslo</h2><form action=profile.php method='post'>
  Heslo:<br><input type='text' name='pwd'><br>
  <input type='hidden' name='id' value='$id'>
  <button type='submit' name='submitpwdbutton'>Potvrdit heslo</button>
  </form>");
}

function handle_profile_change($db){
  if(isset($_POST['submitbutton'])){
    $firstname= $_POST['firstname'];
    $lastname= $_POST['lastname'];
    $mail = $_POST['mail'];
    $submitbutton= $_POST['submitbutton'];
    $id = $_SESSION['user_id'];

    if ($firstname == '' || $lastname == '' || $mail == '' ){
        header("Location: ./profile.php?&err=empty_fields");
        exit();
    }

    if($mail != $_SESSION['mail']){
      $query = "SELECT Uzivatele_ID FROM uzivatele WHERE email = '$mail'";
      $result = mysqli_query($db, $query);
      if(mysqli_num_rows($result) > 0){
        header("Location: ./profile.php?&err=mail_taken");
        exit();
      }
    }

    $query = "UPDATE uzivatele SET jmeno='$firstname', prijmeni='$lastname', email='$mail' WHERE Uzivatele_ID='$id'";
    $result = mysqli_query($db, $query);

    if ($result){
      header("Location: ./profile.php?id=$id&succ=updated");
    }
    else{
      header("Location: ./profile.php?id=$id&err=sql");
    }
    exit();
  }
}

function handle_pwd_change($db){
  if(isset($_POST['submitpwdbutton'])){
    $id = $_SESSION['user_id'];
    $pwd= $_POST['pwd'];
    if ($pwd == ''){
        header("Location: ./profile.php?&err=empty_field");
        exit();
    }

    $pwd_hash = pwd_crypt($pwd);
    
    $query = "UPDATE uzivatele SET heslo='$pwd_hash' WHERE Uzivatele_ID='$id'";
    if (mysqli_query($db, $query)){
      header("Location: ./profile.php?&succ=updated");
    }
    else{
      header("Location: ./profile.php?&err=sql");
    }
    exit();
  }
}

require_once("dbh.php");
require_once("fn.pwd_hash.php");

show_edit_profile_form($db);
show_edit_pwd_form();
insert_reverse_tile("Zpìt na hlavní pøehled", "./index.php");
handle_profile_change($db);
handle_pwd_change($db);
?>

</container>
</body>

</html>
