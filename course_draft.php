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
    course_compare_draft();
    insert_delete_tile("Zam�tnout zm�ny", "./act.draft_reject.php?id=".$_GET['id']);
    insert_confirm_tile("Potvrdit zm�ny", "./act.draft_confirm.php?id=".$_GET['id']);
    insert_reverse_tile("Zp�t hlavn� str�nku", "./index.php");
  ?>
  </container>
</body>

</html>
