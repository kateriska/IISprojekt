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
  tile_create_course();
  table_all_courses();
  insert_reverse_tile("Zpět na hlavní přehled", "./index.php");
?>
  </container>
</body>

</html>
