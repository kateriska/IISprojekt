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
  if(!check_add_event($_GET['id'])){
    header("Location: ./index.php");
    exit();
  }
  insert_login_bar();
  alert_if('inv_fields', 'D�lka trv�n� nesm� b�t z�porn�');
  $cl_course = get_val('cl_course');
  $cl_ev_type = get_val('cl_ev_type');
  alert_if('clash', "Tvo�en� term�n se p�ekr�v� s term�nem typu $cl_ev_type kurzu $cl_course");
  $type = get_val('type');
  $date = get_val('date');
  $time = get_val('time');
  $dur = get_val('dur');
  $room= get_val('room');
  $lector= get_val('lector');
  $desc = get_val('desc');
?>

  <container class="center">
  <h1>Vytvo�it nov� term�n kurzu <?php echo($_GET['id'])?></h1>
    <form action=act.event_create.php method='post'>
      Typ:<br><input type='text' name='type' value=<?php echo($type) ?><br>
      Datum*:<br><input type='date' name='date' required value=<?php echo($date) ?><br>
      �as*:<br><input type='time' name='time' required value=<?php echo($time) ?><br>
      D�lka trv�n� (minuty):<br><input type='number' name='duration' value=<?php echo($dur) ?><br>
      <?php
        insert_room_select($room);
        insert_lector_select($lector);
        ?>
      Popis:<br><textarea name='description' ><?php echo($desc) ?></textarea><br>
      <input type='hidden' name='id' value='<?php echo($_GET['id'])?>'>
      <button type='submit' name='event_create_submit'>Vytvo�it</button>
    </form>
    <?php
      insert_reverse_tile("Zp�t na detail kurzu", "./course.php?id=".$_GET['id']);
    ?>
  </container>
</body>
</html>
