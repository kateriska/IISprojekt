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
  if(!check_rights(ADMIN)){
    header("Location: ./index.php");
    exit();
  }
  if($_GET['id'] == ""){
    header("Location: ./users.php");
    exit();
  }
  alert_if('no_selfdelete', "Nem��ete smazat sami sebe!");
  insert_login_bar();
?>

  <container class="center">
  <h1>�prava u�ivatele</h1>
<?php 
  get_modifiable_user_details($_GET['id']);
  get_user_set_pwd($_GET['id']);
  get_user_delete($_GET['id']);
  insert_reverse_tile("Zp�t na seznam u�ivatel�", "./users.php");
?>
  </container>
</body>

</html>
