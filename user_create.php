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
  if(!check_rights(ADMIN)){
    header("Location: ./index.php");
    exit();
  }
  insert_login_bar();
?>

  <container class="center">
  <h1>Vytvořit nového uživatele</h1>
    <form action=act.user_create.php method='post'>
      Jméno:<br><input type='text' name='firstname'><br>
      Příjmení:<br><input type='text' name='lastname'><br>
      Role:<br><select name='role'>
        <option value='1' selected>Student</option>
        <option value='2'>Lektor</option>
        <option value='3'>Garant</option>
        <option value='4'>Vedoucí</option>
        <option value='5'>Administrátor</option>
      </select><br>
      Email:<br><input type='text' name='mail'><br>
      Heslo:<br><input type='password' name='pwd'><br>
      <button type='submit' value='user_edit_submit'>Vytvořit</button>
    </form>
  </container>
</body>

</html>
