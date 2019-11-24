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

function get_profile_details($id, $db){
  $query = "SELECT jmeno, prijmeni, email FROM uzivatele WHERE Uzivatele_ID='$id'";
  $result = mysqli_query($db, $query);
  if($result === FALSE){ //SQL ERR
    echo("CHYBA SQL");return;
  }

  $row = mysqli_fetch_assoc($result);

  $firstname = htmlspecialchars($row['jmeno']);
  $lastname = htmlspecialchars($row['prijmeni']);
  $mail = htmlspecialchars($row['email']);
  $r_str = "<h2>Upravit údaje</h2><form action=profile.php method='post'>
              Jméno:<br><input type='text' name='firstname' value='$firstname'><br>
              Pøíjmení½:<br><input type='text' name='lastname' value='$lastname'><br>
              Email:<br><input type='text' name='mail' value='$mail'><br>
              <input type='hidden' name='id' value='$id'>
              <button type='submit' name='submitbutton'>Potvrdit zmìny</button>
            </form>";
  echo($r_str);


  if ((isset($_POST['submitbutton'])) && (isset($_POST['firstname'])) && (isset($_POST['lastname'])) && (isset($_POST['mail'])))
  {
    $firstname= $_POST['firstname'];
    $lastname= $_POST['lastname'];
    $mail = $_POST['mail'];
    $submitbutton= $_POST['submitbutton'];
    $id = $_POST['id'];

    if ($firstname == '' || $lastname == '' || $mail == '' )
    {
        header("Location: ./profile.php?id=$id&err=empty_field");
        exit();
    }

    $query = "UPDATE uzivatele SET jmeno='$firstname', prijmeni='$lastname', email='$mail' WHERE Uzivatele_ID='$id'";

    mysqli_query($db, $query);

    if (mysqli_query($db, $query))
    {
      header("Location: ./profile.php?id=$id&succ=created");
    }
    else
    {
      header("Location: ./profile.php?id=$id&err=mail_taken");
    }


    exit();

  }

  $query = "SELECT heslo FROM uzivatele WHERE Uzivatele_ID='$id'";
  $result = mysqli_query($db, $query);
  if($result === FALSE){ //SQL ERR
    echo("CHYBA SQL");return;
  }

  $row = mysqli_fetch_assoc($result);

  $pwd = htmlspecialchars($row['heslo']);

  $p_str = "<h2>Upravit heslo</h2><form action=profile.php method='post'>
            Heslo:<br><input type='text' name='pwd'><br>
            <input type='hidden' name='id' value='$id'>
            <button type='submit' name='submitpwdbutton'>Potvrdit heslo</button>
          </form>";
  echo($p_str);

  if (isset($_POST['pwd']) && (isset($_POST['submitpwdbutton'])))
  {
    $pwd= $_POST['pwd'];
    $submitbutton= $_POST['submitpwdbutton'];
    $id = $_POST['id'];

    if ($pwd == '')
    {
        header("Location: ./profile.php?id=$id&err=empty_field");
        exit();
    }


    $pwd_hash = pwd_crypt($pwd);

    $query = "UPDATE uzivatele SET heslo='$pwd_hash' WHERE Uzivatele_ID='$id'";

    if (mysqli_query($db, $query))
    {
      header("Location: ./profile.php?id=$id&succ=created");
    }
    else
    {
      header("Location: ./profile.php?id=$id&err=empty_field");
    }

    exit();
}



}

require_once("dbh.php");
require_once("fn.pwd_hash.php");


get_profile_details($_GET['id'], $db);




?>

</container>
</body>

</html>
