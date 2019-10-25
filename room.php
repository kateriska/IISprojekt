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
  if($_GET['id'] == ""){
    header("Location: ./rooms.php");
    exit();
  }
  insert_login_bar();
?>

  <container class="center">
  <h1>�prava m�stnosti</h1>
<?php 
  get_modifiable_room_details($_GET['id']);
  get_room_delete($_GET['id']);
  insert_reverse_tile("Zp�t na seznam m�stnost�", "./rooms.php");
?>
  </container>
</body>

</html>
