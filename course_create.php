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
  if(!check_rights(GARANT)){
    header("Location: ./index.php");
    exit();
  }
  insert_login_bar();
  alert_if('id_taken', 'ID kurzu zabr�no, zvolte pros�m jin�');
?>

  <container class="center">
  <h1>Vytvo�it nov� kurz</h1>
    <form action=act.course_create.php method='post'>
      ID*:<br><input type='text' name='id' required><br>
      N�zev*:<br><input type='text' name='name' required><br>
      Typ:<br><input type='text' name='type'><br>
      Cena:<br><input type='number' name='price'><br>
            <?php 
        insert_select_garant($_SESSION['user_id']); 
        insert_select_deputy_head($_SESSION['user_id']);
            ?>
      Popis:<br><textarea name='description' ></textarea><br>
      <button type='submit' name='course_create_submit'>Vytvo�it</button>
    </form>
    <?php
      insert_reverse_tile("Zp�t na seznam kurz�", "./courses.php");
    ?>
  </container>
</body>

</html>
