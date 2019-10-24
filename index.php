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
  require_once('fn.pwd_hash.php');

  $hash = pwd_crypt('epal');
  echo($hash.'<br>');
  $hash = pwd_crypt('amal');
  echo($hash.'<br>');
  $hash = pwd_crypt('ista');
  echo($hash.'<br>');
  $hash = pwd_crypt('khum');
  echo($hash.'<br>');
  $hash = pwd_crypt('anov');
  echo($hash.'<br>');
  $hash = pwd_crypt('ahaj');
  echo($hash.'<br>');
  $hash = pwd_crypt('lota');
  echo($hash.'<br>');
  $hash = pwd_crypt('zfor');
  echo($hash.'<br>');
  $hash = pwd_crypt('zsti');
  echo($hash.'<br>');
?>

  <container class="center">
<?php 
  //TODO show_pending_student_registrations();       //G
  //TODO show_my_courses_student();                  //S
  //TODO show_my_courses_lecturer();                 //L
  //TODO show_my_courses_garant();                   //G
  tile_manage_rooms();                        //M
  tile_manage_users();                        //A
  tile_show_all_courses();                    //N
  tile_edit_profile();                        //S
?>
  </container>
</body>

</html>
