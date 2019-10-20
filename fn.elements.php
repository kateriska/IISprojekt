<?php
function insert_tile($name, $url){
  echo("<a href='./$url' class='tile'>&rarr; $name</a>");
}

function insert_login_bar(){
  if(isset($_SESSION['user_id'])){
    echo("<container id='login_bar'>
          <form id='login' action='act.logout.php' method='post'>
            <button type='submit' name='submit_login'>Logout</button>
          </form>
          </container>");
  }else{
    echo("<container id='login_bar'>
          <form id='login' action='act.login.php' method='post'>
            <input type='text' name='mail' placeholder='Email'>
            <input type='password' name='pwd' placeholder='Heslo'>
            <button type='submit' name='submit_login'>Login</button>
          </form>
          </container>");
  }


}




?>