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
  $name = $_GET['name'];
  $type = $_GET['type'];
  $price = $_GET['price'];
  $garant = $_GET['garant'];
  $dep_head = $_GET['dep_head'];
  $desc = $_GET['description'];
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
