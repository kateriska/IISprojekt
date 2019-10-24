<?php
 
const STUDENT          = 1;
const LECTURER         = 2;
const GARANT           = 3;
const FACILITY_MANAGER = 4;
const ADMIN            = 5;

function insert_tile($name, $url){
  echo("<a href='./$url' class='tile'>&rarr; $name</a>");
}

function insert_login_bar(){
  if(isset($_SESSION['user_id'])){
    echo("<container id='login_bar'>
          <form id='logout' action='act.logout.php' method='post'>
            <button type='submit' name='submit_logout'>Logout</button>
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

function check_rights($role){
  if(isset($_SESSION['user_id']) && isset($_SESSION['role'])){
    if($_SESSION['role'] >= $role){
      return true;
    }
  }
  return false;
}


function tile_show_all_courses(){
  insert_tile("Zobrazit v¹echny kurzy", "./courses.php");
}

function tile_manage_rooms(){
  if( check_rights(FACILITY_MANAGER) ){
    insert_tile("Správa místností", "./rooms.php");
  }
}

function tile_manage_users(){
  if( check_rights(ADMIN) ){
    insert_tile("Správa u¾ivatelù", "./users.php");
  }
}

function tile_edit_profile(){
  if( check_rights(STUDENT) ){
    insert_tile("Upravit profil", "./profile.php");
  }
}

function table_all_courses(){
  require_once("dbh.php");

  $query = "SELECT Kurzy_ID, nazev, typ, cena FROM kurzy";

  $result = mysqli_query($db, $query);
  if($result === FALSE){ //SQL ERR
    echo("CHYBA SQL");
    mysqli_free_result($result);return;
  }

  $r_table = "<table id='courses'>";
  while($row = mysqli_fetch_assoc($result)){
    $r_table .= "<tr><td>$row['Kurzy_ID']</td><td>$row['nazev']</td><td>$row['typ']</td><td>$row['cena']</td></tr>"; 
  }
  $r_table .= "</table>"
  echo($r_table);
  mysqli_free_result($result);
}



?>