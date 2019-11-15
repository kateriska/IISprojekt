<?php
$db = mysqli_init();
$login = "xholub42"; 
$password = "n4etimbe";

if (!mysqli_real_connect($db, 'localhost', $login, $password, $login, 0, '/var/run/mysql/mysql.sock')){
  die('cannot connect '. mysqli_connect_error());
}

?>