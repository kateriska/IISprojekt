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
<?php 
  $id = $_SESSION['user_id'];
  require_once('dbh.php');
  show_pending_student_registrations($id, $db);       //G
  show_my_courses_student($id, $db);                  //S
  show_my_courses_lecturer($id, $db);                 //L
  show_my_courses_garant($id, $db);                   //G
  tile_manage_rooms();                        //M
  tile_manage_users();                        //A
  tile_show_all_courses();                    //N
  tile_edit_profile();                        //S
?>
  </container>
</body>

</html>
