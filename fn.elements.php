<?php
 
const STUDENT          = 1;
const LECTURER         = 2;
const GARANT           = 3;
const DEPARTMENT_HEAD  = 4;
const ADMIN            = 5;

function insert_tile($name, $url){
  echo("<a href='./$url' class='tile'>&rarr; $name</a>");
}

function insert_reverse_tile($name, $url){
  echo("<a href='./$url' class='tile'>&larr; $name</a>");
}

function inser_up_tile($name, $url){
  echo("<a href='./$url' class='tile'>&uarr; $name</a>");
}

function insert_create_tile($name, $url){
  echo("<a href='./$url' class='tile'>+ $name</a>");
}

function insert_delete_tile($name, $url){
  echo("<a href='./$url' class='tile'>? $name</a>");
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
  if( check_rights(DEPARTMENT_HEAD) ){
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
    $course_id = htmlspecialchars($row['Kurzy_ID']);
    $nazev = htmlspecialchars($row['nazev']);
    $typ = htmlspecialchars($row['typ']);
    $cena = htmlspecialchars($row['cena']);
    $r_table .= "<tr><td><b>$course_id</b></td><td><a href='./course?id=$course_id'>$nazev</a></td><td>$typ</td><td>$cena</td></tr>"; 
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

  $nazev = htmlspecialchars($row['nazev']);
  $garant_name = htmlspecialchars($row['jmeno']) ." ". htmlspecialchars($row['prijmeni']);
  $garant_mail = htmlspecialchars($row['email']);
  $typ = htmlspecialchars($row['typ']);
  $cena_text = "";
  if($row['cena'] != 0){
    $cena_text = "<b>Cena: </b>".htmlspecialchars($row['cena'])."<br>";
  }
  $popis = htmlspecialchars($row['popis']);

  $r_str = "<h1>$id - $nazev</h1><br><b>Garant:</b> $garant_name (<a href='mailto:$garant_mail'>$garant_mail</a>)<br><b>Typ: </b>$typ<br>$cena_text$popis<br>";
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
    $id = htmlspecialchars($row['Uzivatele_ID']);
    $jmeno = htmlspecialchars($row['jmeno']) ." ". htmlspecialchars($row['prijmeni']);
    $role = role_to_text($row['role']);
    $email = htmlspecialchars($row['email']);
    $r_table .= "<tr><td><a href='./user?id=$id'>$jmeno</a></td><td>$role</td><td><a href='mailto:$email'>$email</a></td></tr>"; 
  }
  $r_table .= "</table><br>";
  echo($r_table);
  mysqli_free_result($result);
}

function get_modifiable_user_details($id){
  require_once("dbh.php");
  $query = "SELECT jmeno, prijmeni, `role` , email FROM uzivatele WHERE Uzivatele_ID='$id'";
  $result = mysqli_query($db, $query);
  if($result === FALSE){ //SQL ERR
    echo("CHYBA SQL");return;
  }

  $row = mysqli_fetch_assoc($result);
  if(!$row){  //USER NOT FOUND
    header("Location: ./users.php?info=$id");
    exit();
  }
  $s1=""; $s2=""; $s3=""; $s4=""; $s5="";

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
  $r_str = "<h2>Upravit údaje</h2><form action=act.user_update.php method='post'>
              Jméno:<br><input type='text' name='firstname' value='$firstname'><br>
              Pøíjmení:<br><input type='text' name='lastname' value='$lastname'><br>
              Role:<br><select name='role'>
                <option value='1'$s1>Student</option>
                <option value='2'$s2>Lektor</option>
                <option value='3'$s3>Garant</option>
                <option value='4'$s4>Vedoucí</option>
                <option value='5'$s5>Administrátor</option>
              </select><br>
              Email:<br><input type='text' name='mail' value='$mail'><br>
              <input type='hidden' name='id' value='$id'>
              <button type='submit' name='user_edit_submit'>Potvrdit zmìny</button>
            </form>";
  echo($r_str);
}

function get_user_set_pwd($id){
  $r_str = "<h2>Zmìnit heslo u¾ivatele</h2><form action=act.user_pwd_update.php method='post'>
              Nové heslo:<br><input type='text' name='pwd'><br>
              <input type='hidden' name='id' value='$id'>
              <button type='submit' name='user_set_pwd_submit'>Potvrdit zmìnu</button>
            </form>";
  echo($r_str);
}

function get_user_delete($id){
  if($id == $_SESSION['user_id']){
    return;
  }
  $r_str = "<h2>Smazat u¾ivatele</h2><form action=act.user_delete.php method='post'>
              <input type='hidden' name='id' value='$id'>
              <button type='submit' name='user_delete_submit'>Smazat u¾ivatele</button>
            </form>";
  echo($r_str);
}

function table_rooms(){
  require_once("dbh.php");

  $query = "SELECT * FROM mistnosti";

  $result = mysqli_query($db, $query);
  if($result === FALSE){ //SQL ERR
    echo("CHYBA SQL");return;
  }

  $r_table = "<table id='rooms'><tr><th>ID</th><th>Adresa</th><th>Typ</th><th>Kapacita</th></tr>";
  while($row = mysqli_fetch_assoc($result)){
    $id = htmlspecialchars($row['Mistnosti_ID']);
    $address = htmlspecialchars($row['adresa']);
    $type =  htmlspecialchars($row['typ']);
    $capacity = htmlspecialchars($row['kapacita']);
    $r_table .= "<tr><td><a href='./room?id=$id'>$id</a></td><td>$address</td><td>$type</td><td>$capacity</td></tr>"; 
  }
  $r_table .= "</table><br>";
  echo($r_table);
  mysqli_free_result($result);
}

function get_modifiable_room_details($id){
  require_once("dbh.php");
  $query = "SELECT * FROM mistnosti WHERE Mistnosti_ID='$id'";
  $result = mysqli_query($db, $query);
  if($result === FALSE){ //SQL ERR
    echo("CHYBA SQL");return;
  }

  $row = mysqli_fetch_assoc($result);
  if(!$row){  //ROOM NOT FOUND
    header("Location: ./rooms.php?info=$id");
    exit();
  }
  $address = $row['adresa'];
  $type = $row['typ'];
  $capacity = $row['kapacita'];
  $r_str = "<h2>Upravit údaje místnosti $id</h2><form action=act.room_update.php method='post'>
              <input type='hidden' name='id' value='$id'>
              Adresa:<br><input type='text' name='address' value='$address'><br>
              Typ:<br><input type='text' name='type' value='$type'><br>
              Kapacita:<br><input type='number' name='capacity' value='$capacity'><br>
              <button type='submit' name='room_edit_submit'>Potvrdit zmìny</button>
            </form>";
  echo($r_str);
}

function get_room_delete($id){
  $r_str = "<h2>Smazat místnost $id</h2><form action=act.room_delete.php method='post'>
              <input type='hidden' name='id' value='$id'>
              <button type='submit' name='room_delete_submit'>Smazat místnost</button>
            </form>";
  echo($r_str);
}

function show_pending_approval_courses($id, $db){
  $query = "SELECT Kurzy_ID, kurzy.nazev, kurzy.typ, uzivatele.jmeno, uzivatele.prijmeni, uzivatele.email FROM ke_schvaleni_kurz JOIN uzivatele ON ke_schvaleni_kurz.garant_ID = uzivatele.Uzivatele_ID JOIN kurzy ON ke_schvaleni_kurz.Kurzy_ID = kurzy.Kurzy_ID WHERE vedouci_ID='$id'";
  $result = mysqli_query($db, $query);
  if ($result->num_rows > 0) {
    echo "<h1>Následující kurzy vy¾adují schválení:</h1>
          <table class='to_approve'>
            <tr><th>Zkratka kurzu</th> <th>Název kurzu</th> <th>Typ kurzu</th> <th>®adatel</th> </tr>";
    while($row = $result->fetch_assoc())
    {
      $course_id =  htmlspecialchars($row['Kurzy_ID']);
      $nazev =  htmlspecialchars($row['nazev']);
      $typ =  htmlspecialchars($row['typ']);
      $garant = htmlspecialchars($row['jmeno']) ." ". htmlspecialchars($row['prijmeni']);
      $email = htmlspecialchars($row['email']);
      echo "<tr><td><b>$course_id</b></td><td><a href='./course_draft?id=$course_id'>$nazev</a></td><td>$typ</td><td><a href='mailto:$email'>$garant</td></tr>";
    }
    echo "</table> <br>";
  }
}


function compare_rows($row, $d_row, $id){
  $d_head_id = $d_row['vedouci_ID'];
  if($d_head_id != $_SESSION['user_id']){
    header("Location: ./index.php?err=noauth");
    exit();
  }
  $d_nazev = htmlspecialchars($d_row['nazev']);
  $d_garant_name = htmlspecialchars($d_row['jmeno']) ." ". htmlspecialchars($d_row['prijmeni']);
  $d_garant_mail = htmlspecialchars($d_row['email']);
  $d_typ = htmlspecialchars($d_row['typ']);
  $d_popis = htmlspecialchars($d_row['popis']);
  $d_cena = htmlspecialchars($d_row['cena']);
  
  $nazev = htmlspecialchars($row['nazev']);
  $garant_name = htmlspecialchars($row['jmeno']) ." ". htmlspecialchars($row['prijmeni']);
  $garant_mail = htmlspecialchars($row['email']);
  $typ = htmlspecialchars($row['typ']);
  $popis = htmlspecialchars($row['popis']);
  $cena = htmlspecialchars($row['cena']);

  if($nazev == $d_nazev){
   echo("<h1>$id - $d_nazev</h1><br>");
  }else{
    echo("<h1>$id - <del>$nazev</del> <ins>$d_nazev</ins></h1><br>");
  }

  if($garant_name == $d_garant_name){
    echo("<b>Garant:</b> $d_garant_name (<a href='mailto:$d_garant_mail'>$d_garant_mail</a>)<br>");
  }else{
    echo("<b>Garant:</b> <del>$garant_name (<a href='mailto:$garant_mail'>$garant_mail</a>)</del> <ins>$garant_name (<a href='mailto:$d_garant_mail'>$d_garant_mail</a>)</ins><br>");
  }

  if($typ == $d_typ){
    echo("<b>Typ: </b>$d_typ<br>");
  }else{
    echo("<b>Typ: </b><del>$typ</del> <ins>$d_typ</ins><br>");
  }
  
  if($cena == $d_cena){
    echo("<b>Cena: </b>$d_cena<br>");
  }else{
    echo("<b>Cena: </b><del>$cena</del> <ins>$d_cena</ins><br>");
  }

  if($popis == $d_popis){
    echo("$d_popis<br>");
  }else{
    echo("<del>$popis</del><br><ins>$d_popis</ins><br>");
  }

}

function course_compare_draft(){
  if( !isset($_GET['id']) ){
    header("Location: ./index.php?err=compare_not_specified");
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
    echo("Kurz $id - draft nenalezen!");mysqli_free_result($result);
    return FALSE;
  }

  $d_query = "SELECT nazev, popis, typ, cena, jmeno, prijmeni, email, vedouci_ID FROM ke_schvaleni_kurz JOIN uzivatele ON ke_schvaleni_kurz.garant_ID=uzivatele.Uzivatele_ID WHERE Kurzy_ID='$id'";
  $d_result = mysqli_query($db, $d_query);
  if($d_result === FALSE){ //SQL ERR
    echo("CHYBA SQL");
    return FALSE;
  }
  $d_row = mysqli_fetch_assoc($d_result);
  if(!$d_row){
    echo("Kurz $id nenalezen!");mysqli_free_result($d_result);
    return FALSE;
  }

  compare_rows($row, $d_row, $id);

  mysqli_free_result($result); mysqli_free_result($d_result);return TRUE;
}

?>