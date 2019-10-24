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
  insert_login_bar();
?>

  <container class="center">
<?php 
  insert_create_tile("Vytvoøit nového u¾ivatele", "./user_create.php");
  table_users();
  insert_reverse_tile("Zpìt na hlavní pøehled", "./index.php");
?>
  </container>
</body>

</html>
