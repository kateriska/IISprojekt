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
  if( !check_rights(DEPARTMENT_HEAD)){
    header("Location: ./index.php?err=noauth");
    exit();
  }
?>

  <container class="center">
  <?php 
    course_compare_draft();
    insert_reverse_tile("Zpìt hlavní stránku", "./index.php");
  ?>
  </container>
</body>

</html>
