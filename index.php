<html>
<head>
  <link rel="stylesheet" href="style.css">
  <?php
    require_once('fn.elements.php');
    require_once('userCourses.php');
  ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>


<body>
<?php
  session_start();
  insert_login_bar();
?>

  <container class="center">
  <h1>Hlavní stránka</h1>
<?php

  require_once('dbh.php');
  if(isset($_SESSION['user_id'])){
    $id = $_SESSION['user_id'];
    show_all_pending_student_registrations($id, $db);       //G
    show_pending_approval_courses($id, $db);              //M
    show_my_courses_student($id, $db);                  //S
    show_my_courses_lecturer($id, $db);                 //L
    show_my_courses_garant($id, $db);                   //G
    show_my_timetable($id, $db);
  }
  tile_manage_rooms();                        //M
  tile_manage_users();                        //A
  tile_show_all_courses();                    //N
  tile_edit_profile();                        //S
?>
  </container>
</body>

</html>
