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
  alert_if('empty_or_inv_fields', 'Vyplòte prosím v¹echna povinná pole (oznaèena *)');
?>

  <container class="center">
  <h1>Vytvoøit nový kurz</h1>
    <form action=act.course_create.php method='post'>
      ID*:<br><input type='text' name='id'><br>
      Název*:<br><input type='text' name='name'><br>
      Typ:<br><input type='text' name='type'><br>
      Cena:<br><input type='number' name='price'><br>
            <?php 
        insert_select_garant($_SESSION['user_id']); 
        insert_select_deputy_head($_SESSION['user_id']);
            ?>
      Popis:<br><textarea name='description' ></textarea><br>
      <button type='submit' name='course_create_submit'>Vytvoøit</button>
    </form>
    <?php
      insert_reverse_tile("Zpìt na seznam kurzù", "./courses.php");
    ?>
  </container>
</body>

</html>
