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

  $hash = pwd_hash('epal');
  echo($hash.'<br>');
  $hash = pwd_hash('amal');
  echo($hash.'<br>');
  $hash = pwd_hash('ista');
  echo($hash.'<br>');
  $hash = pwd_hash('khum');
  echo($hash.'<br>');
  $hash = pwd_hash('anov');
  echo($hash.'<br>');
  $hash = pwd_hash('ahaj');
  echo($hash.'<br>');
  $hash = pwd_hash('lota');
  echo($hash.'<br>');
  $hash = pwd_hash('zfor');
  echo($hash.'<br>');
  $hash = pwd_hash('zsti');
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
