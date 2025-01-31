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
  if(!check_rights(DEPARTMENT_HEAD)){
    header("Location: ./index.php");
    exit();
  }
  insert_login_bar();
  $id = get_val('id');
  $add = get_val('add');
  $type = get_val('type');
  $cap = get_val('cap');
  alert_if('id_taken', "Identifik�tor $id je ji� zabr�n, zvolte pros�m jin�.");
?>

  <container class="center">
  <h1>Zadat novou m�stnost</h1>
    <form action=act.room_create.php method='post'>
      ID*:<br><input type='text' name='room_id' required value="<?php echo($id) ?>"><br>
      Adresa:<br><input type='text' name='address' value="<?php echo($add) ?>"><br>
      Typ:<br><input type='text' name='type' value="<?php echo($type) ?>"><br>
      Kapacita*:<br><input type='number' name='capacity' min='1' required value="<?php echo($cap) ?>"><br>
      <button type='submit' name='room_create_submit'>Vytvo�it</button>
    </form>
    <?php
      insert_reverse_tile("Zp�t na seznam m�stnost�", "./rooms.php");
    ?>
  </container>
</body>

</html>
