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
?>

  <container class="center">
  <h1>Vytvoøit nový termín kurzu <?php echo($_GET['id'])?></h1>
    <form action=act.event_create.php method='post'>
      Typ:<br><input type='text' name='description'><br>
      Datum:<br><input type='date' name='date'><br>
      Èas:<br><input type='time' name='time'><br>
      Délka trvání (minuty):<br><input type='number' name='duration'><br>
      <?php
        insert_room_select();
        insert_lector_select();
        ?>
      Popis:<br><input type='text' name='description'><br>
      <button type='submit' name='event_create_submit'>Vytvoøit</button>
    </form>
    <?php
      insert_reverse_tile("Zpìt na seznam kurzù", "./courses.php");
    ?>
  </container>
</body>
</html>
