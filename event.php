<html>
<head>
  <link rel="stylesheet" href="style.css">
  <?php
    require_once('fn.elements.php');
    require_once('event_files.php');
  ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>


<body>
<?php
  session_start();
  insert_login_bar();
  alert_if('room_occupied', "M�stnost je v tuto dobu zabr�na");
  alert_if('inv_dur', "Doba trv�n� nesm� b�t z�porn�");
  alert_if('l_file', "Soubor nesm� b�t v�t�� ne� 50MB");
?>

  <container class="center">
  <?php
    event_show_info_or_edit($_GET['id'], $_GET['d'], $_GET['t'], $_GET['r']);         //pro zapsane/ editace a mazani vlastnenym lektorum, garantum a vedoucim
    event_delete();                    //vlastnikum krome lektoru
    get_event_files($_GET['id'], $_GET['d'], $_GET['t'], $_GET['r']);
    insert_reverse_tile("Zp�t na kurz ".$_GET['id'], "./course.php?id=".$_GET['id']);
    event_tile_insert_marks($_GET['id'], $_GET['d'], $_GET['t'], $_GET['r']);
  ?>
  </container>
</body>

</html>
