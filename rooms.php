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
  if(!check_rights(DEPARTMENT_HEAD)){
    header("Location: ./index.php");
    exit();
  }
  insert_login_bar();
?>

  <container class="center">
<?php 
  insert_create_tile("Zadat novou m�stnost u�ivatele", "./room_create.php");
  table_rooms();
  insert_reverse_tile("Zp�t na hlavn� p�ehled", "./index.php");
?>
  </container>
</body>

</html>
