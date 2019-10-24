<?php
 
const STUDENT          = 1;
const LECTURER         = 2;
const GARANT           = 3;
const FACILITY_MANAGER = 4;
const ADMIN            = 5;

function insert_tile($name, $url){
  echo("<a href='./$url' class='tile'>&rarr; $name</a>");
}

function insert_reverse_tile($name, $url){
  echo("<a href='./$url' class='tile'>&larr; $name</a>");
}

function insert_create_tile($name, $url){
  echo("<a href='./$url' class='tile'>+ $name</a>");
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
    return;
  }

  $r_table = "<table id='courses'><tr><th>ID</th><th>Název</th><th>Typ</th><th>Cena</th></tr>";
  while($row = mysqli_fetch_assoc($result)){
    $course_id = $row['Kurzy_ID'];
    $r_table .= "<tr><td><b>$course_id</b></td><td><a href='./course?id=$course_id'>".$row['nazev']."</a></td><td>".$row['typ']."</td><td>".$row['cena']."</td></tr>"; 
  }
  $r_table .= "</table>";
  echo($r_table);
  mysqli_free_result($result);
}

function tile_create_course(){
  if( check_rights(GARANT) ){
    insert_create_tile("Zalo¾it nový kurz", "./course_create.php");
  }
}

function course_get_info(){
  if( !isset($_GET['id']) ){
    header("Location: ./courses.php");
    exit();
  }
  require_once("dbh.php");
  $id = $_GET['id'];
  $query = "SELECT nazev, popis, typ, cena, jmeno, prijmeni, email FROM kurzy JOIN uzivatele ON kurzy.garant_ID=uzivatele.Uzivatele_ID WHERE Kurzy_ID='$id'";
  $result = mysqli_query($db, $query);
  if($result === FALSE){ //SQL ERR
    echo("CHYBA SQL");
    return FALSE;
  }
  $row = mysqli_fetch_assoc($result);
  if(!$row){
    $r_str = "Kurz $id nenalezen!";
    echo($r_str);mysqli_free_result($result);
    return FALSE;
  }

  $nazev = $row['nazev'];
  $garant_name = $row['jmeno'] ." ". $row['prijmeni'];
  $garant_mail = $row['email'];
  $typ = $row['typ'];
  $cena_text = "";
  if($row['cena'] != 0){
    $cena_text = "<b>Cena: </b>".$row['cena']."<br>";
  }
  $popis = $row['popis'];

  $r_str = "<h1>$id - $nazev</h1><br><b>Garant:</b> $garant_name (<a href='mailto:$garant_mail'>$garant_mail</a>)<br><b>Typ: </b>$typ<br>$cena_text$popis";
  echo($r_str);mysqli_free_result($result);return TRUE;
}

function role_to_text($role){
  if($role == 1){
    return 'student';
  }
  if($role == 2){
    return 'lektor';
  }
  if($role == 3){
    return 'garant';
  }
  if($role == 4){
    return 'vedoucí';
  }
  if($role == 5){
    return 'administrátor';
  }
  return "";
}

function table_users(){
  require_once("dbh.php");

  $query = "SELECT Uzivatele_ID, jmeno, prijmeni, `role`, email FROM uzivatele";

  $result = mysqli_query($db, $query);
  if($result === FALSE){ //SQL ERR
    echo("CHYBA SQL");return;
  }

  $r_table = "<table id='users'><tr><th>Jméno</th><th>Role</th><th>Email</th></tr>";
  while($row = mysqli_fetch_assoc($result)){
    $id = $row['Uzivatele_ID'];
    $jmeno = $row['jmeno'] ." ". $row['prijmeni'];
    $role = role_to_text($row['role']);
    $email = $row['email'];
    $r_table .= "<tr><td><a href='./user?id=$id'>$jmeno</a></td><td>$role</td><td><a href='mailto:$email'>$email</a></td></tr>"; 
  }
  $r_table .= "</table>";
  echo($r_table);
  mysqli_free_result($result);
}

function get_modifiable_user_details($id){
  require_once("dbh.php");
  $query = "SELECT * FROM uzivatele";// WHERE Uzivatele_ID='$id'";
  $result = mysqli_query($db, $query);
  if($result === FALSE){ //SQL ERR
    echo("CHYBA SQL");return;
  }

  $row = mysqli_fetch_assoc($result);
  if(!$row){  //USER NOT FOUND
    header("Location: ./users.php?info=$id");
    exit();
  }

  $role = $row['role'];
  switch ($role) {
    case 1:
      $s1 = " selected";
      break;
    case 2:
      $s2 = " selected";
      break;
    case 3:
      $s3 = " selected";
      break;
    case 4:
      $s4 = " selected";
      break;
    case 5:
      $s5 = " selected";
      break;
  }
  $firstname = $row['jmeno'];
  $lastname = $row['prijmeni'];
  $mail = $row['email'];
  $r_str = "<form action=act.user_update.php method='post'>
              Jméno:<br><input type='text' name='firstname' value='$firstname'><br>
              Pøíjmení:<br><input type='text' name='lastname' value='$lastname'><br>
              Role:<br><select name='role'>
                <option value='1'$s1>Student</option>
                <option value='1'$s2>Lektor</option>
                <option value='1'$s3>Garant</option>
                <option value='1'$s4>Vedoucí</option>
                <option value='1'$s5>Administrátor</option>
              </select><br>
              Email:<br><input type='text' name='mail' value='$mail'><br>";
  echo($r_str);
}
?>