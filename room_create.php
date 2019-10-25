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
?>

  <container class="center">
  <h1>Zadat novou místnost</h1>
    <form action=act.room_create.php method='post'>
      ID:<br><input type='text' name='room_id'><br>
      Adresa:<br><input type='text' name='address'><br>
      Typ:<br><input type='text' name='type'><br>
      Kapacita:<br><input type='number' name='capacity' min='1'><br>
      <button type='submit' name='room_create_submit'>Vytvoøit</button>
    </form>
    <?php
      insert_reverse_tile("Zpìt na seznam místností", "./rooms.php");
    ?>
  </container>
</body>

</html>
