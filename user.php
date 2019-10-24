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
  get_modifiable_user_details($_GET['id']);
  insert_reverse_tile("Zpìt na seznam u¾ivatelù", "./users.php");
?>
  </container>
</body>

</html>
