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
    course_get_info();
    insert_reverse_tile("Zpět na seznam kurzů", "./courses.php");
  ?>
  </container>
</body>

</html>
