<?php

function pwd_crypt($pwd, $rounds = 9){
  $salt = "";
  $salt_chars = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
  for($i=0; $i<22; $i++){
      $salt .= $salt_chars[array_rand($salt_chars)];
  }
  return crypt($pwd, sprintf('$2y$%02d$', $rounds) . $salt);
}

function pwd_verify($pwd, $hash){
  if(crypt($pwd, $hash) == $hash){
    return TRUE;
  }else{
    return FALSE;
  }
}

?>

