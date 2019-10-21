<?php

if(!isset($argv[1]) || !isset($argv[2])){
  echo("error: no args!");
  exit(0);
}

$db = mysqli_init();
$login = $argv[1];
$password = $argv[2];

if (!mysqli_real_connect($db, 'localhost', $login, $password, $login, 0, '/var/run/mysql/mysql.sock')){
  die('cannot connect '.mysqli_connect_error());
}

?>