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
    if(isset($_SESSION['user_id'])){
      show_pending_student_registrations($_GET['id'], $_SESSION['user_id']);
    }
    course_show_add_event($_GET['id']);
    course_show_events($_GET['id']);                      //viditelne vsem, zapsanym se zobrazi i hodnoceni
    //course_get_course_files();               TODO: soubory pro vsechny/registrovane/zapsane
    insert_reverse_tile("Zpìt na seznam kurzù", "./courses.php");
  ?>
  </container>
</body>

</html>
