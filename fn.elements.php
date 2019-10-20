<?php
function insert_tile($name, $url){
  echo("<a href='./$url' class='tile'>&rarr; $name</a>");
}

function insert_login_bar(){
  echo("<div id='login_bar'>
        <form id='login' action='act.login.php' method='post'>
          <input type='text' name='mail' placeholder='Email'>
          <input type='password' name='pwd' placeholder='Heslo'>
          <button type='submit' name='submit_login'>Login</button>
        </form>
        </div>");
}




?>