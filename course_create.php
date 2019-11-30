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
  alert_if('id_taken', 'ID kurzu zabráno, zvolte prosím jiné');
  alert_if('inv_price', 'Cena musí být nezáporná.');
  $name = get_val('name');
  $type = get_val('type');
  $price = get_val('price');
  $garant = get_val('garant');
  $dep_head = get_val('dep_head');
  $desc = get_val('description');
?>

  <container class="center">
  <h1>Vytvoøit nový kurz</h1>
    <form action=act.course_create.php method='post'>
      ID*:<br><input type='text' name='id' required><br>
      Název*:<br><input type='text' name='name' required value=<?php echo("$name"); ?>><br>
      Typ:<br><input type='text' name='type' value=<?php echo("$type"); ?>><br>
      Cena:<br><input type='number' name='price' value=<?php echo("$price"); ?>><br>
            <?php 
        insert_select_garant($_SESSION['user_id']); 
        insert_select_deputy_head($_SESSION['user_id']);
            ?>
      Popis:<br><textarea name='description' ><?php echo("$desc"); ?></textarea><br>
      <button type='submit' name='course_create_submit'>Vytvoøit</button>
    </form>
    <?php
      insert_reverse_tile("Zpìt na seznam kurzù", "./courses.php");
    ?>
  </container>
</body>

</html>
