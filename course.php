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
    course_show_info_or_edit();
    course_show_add_event();
    //course_show_events();
    //course_get_participant_info();           TODO: tabulka terminu s hodnocenim, mistnosti, lektorem a celkove hodnoceni.
    //course_get_course_files();               TODO: soubory pro vsechny/registrovane/zapsane
    insert_reverse_tile("Zp�t na seznam kurz�", "./courses.php");
  ?>
  </container>
</body>

</html>
