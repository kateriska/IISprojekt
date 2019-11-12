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
  $r_str = "<h2>Upravit své údaje</h2><form action=updateMyProfile.php method='post'>
              Jméno:<br><input type='text' name='firstname' value='$firstname'><br>
              Pøíjmení:<br><input type='text' name='lastname' value='$lastname'><br>
              Email:<br><input type='text' name='mail' value='$mail'><br>
              Heslo:<br><input type='text' name='password'><br>
              <button type='submit' name='submitbutton'>Potvrdit zmìny</button>
            </form>";
  echo($r_str);

  $firstname= $_POST['firstname'];
  $lastname= $_POST['lastname'];
  $mail = $_POST['mail'];
  $pwd= $_POST['password'];
  $submitbutton= $_POST['submitbutton'];
  if (isset($submitbutton))
  {
    if (empty($pwd))
    {
      $query = "UPDATE uzivatele SET jmeno='$firstname', prijmeni='$lastname', email='$mail' WHERE Uzivatele_ID='$id'";

      mysqli_query($db, $query);
    }
    else
    {
      $pwd_hash = pwd_crypt($pwd);

      $query = "UPDATE uzivatele SET jmeno='$firstname', prijmeni='$lastname', email='$mail', heslo='$pwd_hash' WHERE Uzivatele_ID='$id'";

      mysqli_query($db, $query);
    }

    exit();

  }
}

require_once("dbh.php");
require_once("fn.pwd_hash.php");
get_profile_details(1, $db);

?>

</container>
</body>

</html>
