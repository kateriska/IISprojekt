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
  echo("<a href='./$url' class='tile'>× $name</a>");
}

function insert_confirm_tile($name, $url){
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

  $query = "SELECT Kurzy_ID, nazev, typ, cena FROM kurzy WHERE cena>'-1'";

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
  $query = "SELECT ke_schvaleni_kurz.Kurzy_ID, kurzy.nazev, kurzy.typ, uzivatele.jmeno, uzivatele.prijmeni, uzivatele.email FROM ke_schvaleni_kurz JOIN uzivatele ON ke_schvaleni_kurz.zadatel_ID = uzivatele.Uzivatele_ID JOIN kurzy ON ke_schvaleni_kurz.Kurzy_ID = kurzy.Kurzy_ID WHERE ke_schvaleni_kurz.vedouci_ID='$id'";
  $result = mysqli_query($db, $query);
  if ($result->num_rows > 0) {
    echo "<b>Následující kurzy vy¾adují schválení:</b>
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
    echo("<b>Garant:</b> <del>$garant_name (<a href='mailto:$garant_mail'>$garant_mail</a>)</del> <ins>$d_garant_name (<a href='mailto:$d_garant_mail'>$d_garant_mail</a>)</ins><br>");
  }

  if($typ == $d_typ){
    echo("<b>Typ: </b>$d_typ<br>");
  }else{
    echo("<b>Typ: </b><del>$typ</del> <ins>$d_typ</ins><br>");
  }
  
  if($cena == $d_cena || $cena == '-1'){
    echo("<b>Cena: </b>$d_cena<br>");
  }else{
    echo("<b>Cena: </b><del>$cena</del> <ins>$d_cena</ins><br>");
  }

  if($popis == $d_popis){
    echo("$d_popis<br>");
  }else{
    echo("<del>$popis</del><br><ins>$d_popis</ins><br><br><br>");
  }

  if($cena == '-1'){
    return TRUE;
  }
  return FALSE;
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
    echo("Kurz $id nenalezen!");mysqli_free_result($d_result);
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
    echo("Kurz $id - draft nenalezen!");mysqli_free_result($result);
    return FALSE;
  }

  $course_to_be_created = compare_rows($row, $d_row, $id);

  $delete_if_would_be_created = '';
  if($course_to_be_created){
    $delete_if_would_be_created = "<input type='hidden' name='delete_original' value='yes'>";
  }


  echo("<form id='reject' action='act.draft_reject.php' method='post'>
          <input type='hidden' name='id' value=$id>
          $delete_if_would_be_created
          <button type='submit' name='submit_reject'>Zamítnout zmìny</button>
        </form>");

  echo("<form id='approve' action='act.draft_approve.php' method='post'>
        <input type='hidden' name='id' value=$id>
        <button type='submit' name='submit_approve'>Schválit zmìny</button>
      </form>");

  mysqli_free_result($result); mysqli_free_result($d_result);return TRUE;
}

function insert_select_garant($current_garant){
  require("dbh.php");
  
  $query = "SELECT Uzivatele_ID, jmeno, prijmeni FROM uzivatele WHERE role>='3' ORDER BY prijmeni, jmeno";
  $result = mysqli_query($db, $query);
  if($result == FALSE){
    echo("CHYBA SQL");
    return FALSE;
  }
  
  echo("Garant:<br><select name='garant'>");
  while( $row = mysqli_fetch_assoc($result) ){
      $garant_id = $row['Uzivatele_ID'];
      if($garant_id == $current_garant){
        $selected = "selected";  
      }else{
        $selected = "";
      }
      $name = $row['prijmeni'] .", ". $row['jmeno'];
      echo("<option value='$garant_id' $selected>$name</option>");
  }
  echo("</select><br>");
}

function insert_select_deputy_head($current_head){
  require("dbh.php");
  
  $query = "SELECT Uzivatele_ID, jmeno, prijmeni FROM uzivatele WHERE role>='4' ORDER BY prijmeni, jmeno";
  $result = mysqli_query($db, $query);
  if($result == FALSE){
    echo("CHYBA SQL");
    return FALSE;
  }
  
  echo("Vedoucí:<br><select name='dep_head'>");
  while( $row = mysqli_fetch_assoc($result) ){
      $dep_head = $row['Uzivatele_ID'];
      $name = $row['prijmeni'] .", ". $row['jmeno'];
      if($dep_head == $current_head){
        $selected = "selected";  
      }else{
        $selected = "";
      }
      echo("<option value='$dep_head' $selected>$name</option>");
  }
  echo("</select><br>");
}

function course_get_info($row){
  $id = $row['Kurzy_ID'];
  $nazev = htmlspecialchars($row['nazev']);
  $garant_name = htmlspecialchars($row['jmeno']) ." ". htmlspecialchars($row['prijmeni']);
  $garant_mail = htmlspecialchars($row['email']);
  $typ = htmlspecialchars($row['typ']);
  $cena_text = "";
  if($row['cena'] != 0){
    $cena_text = "<b>Cena: </b>".htmlspecialchars($row['cena'])." CZK<br>";
  }
  $popis = htmlspecialchars($row['popis']);

  echo("<h1>$id - $nazev</h1><br><b>Garant:</b> $garant_name (<a href='mailto:$garant_mail'>$garant_mail</a>)<br><b>Typ: </b>$typ<br>$cena_text$popis<br>");
}

function course_get_editable_info($row, $isdraft){
  $id = $row['Kurzy_ID'];
  $nazev = htmlspecialchars($row['nazev']);
  $typ = htmlspecialchars($row['typ']);
  $cena = htmlspecialchars($row['cena']);
  $popis = htmlspecialchars($row['popis']);
  $dep_head = $row['vedouci_ID'];
  if($isdraft){
    require("dbh.php");
    $orig_query = "SELECT Kurzy_ID, nazev, popis, typ, cena, jmeno, prijmeni, email, garant_ID, vedouci_ID FROM kurzy JOIN uzivatele ON kurzy.garant_ID=uzivatele.Uzivatele_ID WHERE Kurzy_ID='$id'";
    $orig_result = mysqli_query($db, $orig_query);
    if($orig_result === FALSE){ //SQL ERR
      echo("CHYBA SQL");
    }
    $orig_row = mysqli_fetch_assoc($orig_result);
    course_get_info($orig_row);

    $draftnote = " (draft, èeká na schválení)";
    $draftval = 1;
  }else{
    $draftnote = "";
    $draftval = 0;
  }
  echo("<h2>Upravit údaje kurzu $id $draftnote</h2><form action=act.course_update.php method='post'>
              Název:<br><input type='text' name='name' value='$nazev'><br>");
              insert_select_garant($row['garant_ID']);
              if(check_rights(DEPARTMENT_HEAD)){
                insert_select_deputy_head($row['vedouci_ID']);
              }else{
                echo("<input type='hidden' name='dep_head' value='$dep_head'>");
              }
        echo("Typ:<br><input type='text' name='type' value='$typ'><br>
              Cena:<br><input type='number' name='price' value='$cena'><br>
              Popis:<br><textarea name='desc' >$popis</textarea><br>
              <input type='hidden' name='id' value='$id'>
              <input type='hidden' name='draftval' value='$draftval'>
              <button type='submit' name='course_edit_submit'>Potvrdit zmìny</button>
            </form>");
}

function course_show_info_or_edit(){
  if( !isset($_GET['id']) ){
    header("Location: ./courses.php");
    exit();
  }
  require("dbh.php");
  $id = $_GET['id'];
  $query = "SELECT Kurzy_ID, nazev, popis, typ, cena, jmeno, prijmeni, email, garant_ID, vedouci_ID FROM kurzy JOIN uzivatele ON kurzy.garant_ID=uzivatele.Uzivatele_ID WHERE Kurzy_ID='$id'";
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
  if( !isset($_SESSION['user_id']) ){
    course_get_info($row);
    return;
  }

  if($row['garant_ID'] == $_SESSION['user_id'] || $row['vedouci_ID'] == $_SESSION['user_id']){
    $isdraft = FALSE;
    $query2 = "SELECT * FROM ke_schvaleni_kurz WHERE Kurzy_ID='$id'";
    $result2 = mysqli_query($db, $query2);
    if($result2 === FALSE){ //SQL ERR
      echo("CHYBA SQL");
      return FALSE;
    }
    if(mysqli_num_rows($result2) != 0){
      $row = mysqli_fetch_assoc($result2);
      $isdraft = TRUE;
    }

    course_get_editable_info($row, $isdraft);
  }else{
    course_get_info($row);
  }
}

function check_add_event($id){
  //admin, vedouci kurzu nebo garant kurzu
  if(check_rights(ADMIN)){
    return TRUE;
  }
  
  $query = "SELECT garant_ID, vedouci_ID FROM kurzy WHERE Kurzy_ID='$id'";
  require("dbh.php");

  $result = mysqli_query($db, $query);
  if($result === FALSE){ //SQL ERR
    echo("CHYBA SQL");
    return FALSE;
  }
  $row = mysqli_fetch_assoc($result);
  if($id == $row['garant_ID'] || $id == $row['vedouci_ID'] ){
    return TRUE;
  }
  return FALSE;
}

function course_show_add_event($id){
  if(check_add_event($id)){
    insert_create_tile("Vytvoøit nový termín", "event_create.php?id=$id");
  }
}

function insert_room_select($room = ''){
  require("dbh.php");
  
  $query = "SELECT Mistnosti_ID, adresa, typ FROM mistnosti ORDER BY Mistnosti_ID";
  $result = mysqli_query($db, $query);
  if($result == FALSE){
    echo("CHYBA SQL");
    return FALSE;
  }
  
  echo("Místnost:<br><select name='room'>");
  echo("<option value='' selected>---</option>");
  while( $row = mysqli_fetch_assoc($result) ){
      $id = $row['Mistnosti_ID'];
      $address = $row['adresa'];
      $type = $row['typ'];
      if($room == $id){
        $selected = "selected";
      }else{
        $selected = "";
      }
      echo("<option value='$id' $selected>$id - $type ($address)</option>");
  }
  echo("</select><br>");
}

function insert_lector_select($lector_id = ''){
  require("dbh.php");
  
  $query = "SELECT Uzivatele_ID, jmeno, prijmeni FROM uzivatele WHERE role>='2' ORDER BY prijmeni, jmeno";
  $result = mysqli_query($db, $query);
  if($result == FALSE){
    echo("CHYBA SQL");
    return FALSE;
  }
  
  echo("Lektor:<br><select name='lector'>");
  while( $row = mysqli_fetch_assoc($result) ){
      $lector = $row['Uzivatele_ID'];
      $name = $row['prijmeni'] .", ". $row['jmeno'];
      if($lector == $lector_id){
        $selected = "selected";
      }else{
        $selected = "";
      }

      echo("<option value='$lector' $selected>$name</option>");
  }
  echo("</select><br>");
}

function course_show_events($id){
  require("dbh.php");
  echo("<h3>Termíny:</h3>");
  course_show_add_event($id);

  //verejny vypis
  //TODO vypis pro zapsane
  $query = "SELECT datum, cas, mistnost_ID, typ_termin FROM terminy WHERE Kurzy_ID='$id' ORDER BY datum, cas ASC";

  $result = mysqli_query($db, $query);
  if($result === FALSE){ //SQL ERR
    echo("CHYBA SQL");
    return;
  }

  $zapsan = FALSE;
  $zapsan_header = "";
  $registered = FALSE;
  $me;

  if(isset($_SESSION['user_id'])){
    $me = $_SESSION['user_id'];
    $registered = TRUE;
    $query_zapsane = "SELECT * FROM zapsane_kurzy WHERE Kurzy_ID='$id' AND student_ID='$me'";
    $result_zapsane = mysqli_query($db, $query_zapsane);
    if($result_zapsane === FALSE){ //SQL ERR
      echo("CHYBA SQL  sas");
    }

    if(mysqli_num_rows( $result_zapsane ) != 0){
      $zapsan = TRUE;
      $zapsan_header = "<th>Hodnocení</th>";
    }
  }

  $zapsan_marks = "";
  $r_table = "<table id='events'><tr><th>Datum</th><th>Èas</th><th>Místnost</th><th>Typ (kliknìte pro více detailù)</th>$zapsan_header</tr>";
  while($row = mysqli_fetch_assoc($result)){
    $date = htmlspecialchars($row['datum']);
    $time = htmlspecialchars(substr($row['cas'], 0, 5));
    $room = htmlspecialchars($row['mistnost_ID']);
    $type = htmlspecialchars($row['typ_termin']);
    if($zapsan){
      //$marks = get_marks()//TODO
      $zapsan_marks = "<td></td>";
    }
    $r_table .= "<tr><td>$date</td><td>$time</td><td>$room</td><td><a href='./event?id=$id&d=$date&t=".$row['cas']."&r=$room'>$type</a></td>$zapsan_marks</tr>"; 
  }
  $r_table .= "</table>";
  echo($r_table);

  if( !$zapsan && $registered ){
    $query_pending = "SELECT * FROM ke_schvaleni_student WHERE Kurzy_ID='$id' AND student_ID='$me'";
    $result_pending = mysqli_query($db, $query_pending);
    if($result_pending === FALSE){ //SQL ERR
      echo("CHYBA SQL");
    }
    if(mysqli_num_rows( $result_pending ) === 0){
      echo("<br><h3>Registrace do kurzu:</h3><form action='act.course_register.php' method='post'>
              <input type='hidden' name='id_user' value='$me'>
              <input type='hidden' name='id_course' value='$id'>
              <button type='submit' name='submit_register'>Pøihlásit se do kurzu</button> 
            </form>");
    }else{
      echo("<br><button type='button' disabled>®ádost o pøihlá¹ení odeslána...</button></br>");
    }

  }
  mysqli_free_result($result);
}

function check_view_or_edit_event($row){
  
  if( !isset($_SESSION['user_id'])){
    header("Location: ./course.php?id=".$row['Kurzy_ID']."&err=noauth");
    exit();
  }

  $course = $row['Kurzy_ID'];
  $me = $_SESSION['user_id'];
  if( check_add_event($course) ){
    return TRUE;
  }

  if($me == $row['lektor_ID']){
    return TRUE;
  }

  require("dbh.php");
  $query = "SELECT * FROM zapsane_kurzy WHERE Kurzy_ID='$course' AND student_ID='$me'";
  $result = mysqli_query($db, $query);
  if($result == FALSE){
    echo("CHYBA SQL ".$query);
    return FALSE;
  }

  if(mysqli_num_rows($result) == 0){
    header("Location: ./course.php?id=".$row['Kurzy_ID']."&err=noauth");
    exit();
  }else{
    return FALSE;
  }
}

function show_edit_event($row){
  $id = htmlspecialchars($row['Kurzy_ID']);
  $date = htmlspecialchars($row['datum']);
  $time = htmlspecialchars(substr($row['cas'], 0, 5));
  $room = htmlspecialchars($row['mistnost_ID']);
  $l_name = htmlspecialchars($row['jmeno']) . " ". htmlspecialchars($row['prijmeni']);
  $l_mail = htmlspecialchars($row['email']);
  $lector = $row['lektor_ID'];
  $desc = htmlspecialchars($row['popis']);
  $type = htmlspecialchars($row['typ_termin']);
  $duration = htmlspecialchars($row['doba_trvani']);


  echo("<h1>Termín kurzu $id - $type</h1><br>
        <form action='act.event_update.php' method='post'>
          Typ:<br><input type='text' name='type' value='$type'><br>
          Datum:<br><input type='date' name='date' value='$date'><br>
          Èas:<br><input type='time' name='time' value='$time'><br>
          Délka trvání (minuty):<br><input type='number' name='duration' value='$duration'><br>");
          insert_room_select($room);
          insert_lector_select($lector);
          echo("Popis:<br><textarea name='desc' >$desc</textarea><br>
          <input type='hidden' name='id' value='$id'>
          <input type='hidden' name='prev_room' value='$room'>
          <input type='hidden' name='prev_date' value='$date'>
          <input type='hidden' name='prev_time' value='$time'>
          <button type='submit' name='event_update_submit'>Potvrdit zmìny</button>
          </form>");
}

function show_event_static($row){
  $id = htmlspecialchars($row['Kurzy_ID']);
  $date = htmlspecialchars($row['datum']);
  $time = htmlspecialchars(substr($row['cas'], 0, 5));
  $room = htmlspecialchars($row['mistnost_ID']);
  $l_name = htmlspecialchars($row['jmeno']) . " ". htmlspecialchars($row['prijmeni']);
  $l_mail = htmlspecialchars($row['email']);
  $desc = htmlspecialchars($row['popis']);
  $type = htmlspecialchars($row['typ_termin']);
  $duration = htmlspecialchars($row['doba_trvani']);
  echo("<h1>Termín kurzu $id - $type</h1><br>
        <i>$date - $time ($duration minut)</i><br>
        Místnost: $room<br>
        Lektor: <a href='mailto:$l_mail'>$l_name</a><br><br>
        $desc<br>");
}

function event_show_info_or_edit(){
  $id = $_GET['id'];
  if( !isset($_GET['id']) || !isset($_GET['d']) || !isset($_GET['t']) || !isset($_GET['r'])){
    header("Location: ./course.php?id=$id&err=notset");
    exit();
  }

  $date = $_GET['d'];
  $time = $_GET['t'];
  $room = $_GET['r'];

  require("dbh.php");
  $query = "SELECT jmeno, prijmeni, lektor_ID, email, Kurzy_ID, datum, cas, mistnost_ID, popis, typ_termin, doba_trvani FROM terminy JOIN uzivatele ON lektor_ID = Uzivatele_ID WHERE Kurzy_ID='$id' AND datum='$date' AND cas='$time' AND mistnost_ID='$room'";
  $result = mysqli_query($db, $query);
  if($result == FALSE){
    echo("CHYBA SQL ".$query);
    return FALSE;
  }

  $row = mysqli_fetch_assoc($result);
  if( !isset($row['popis'])){
    header("Location: ./course.php?id=$id&err=notfound");
    exit();
  }

  if( check_view_or_edit_event($row) ){
    show_edit_event($row);
  }else{
    show_event_static($row);
  }
}

function event_delete(){
  $id = $_GET['id'];
  $date = $_GET['d'];
  $time = $_GET['t'];
  $room = $_GET['r'];

  require("dbh.php");
  $query = "SELECT jmeno, prijmeni, lektor_ID, email, Kurzy_ID, datum, cas, mistnost_ID, popis, typ_termin, doba_trvani FROM terminy JOIN uzivatele ON lektor_ID = Uzivatele_ID WHERE Kurzy_ID='$id' AND datum='$date' AND cas='$time' AND mistnost_ID='$room'";
  $result = mysqli_query($db, $query);
  if($result == FALSE){
    echo("CHYBA SQL ".$query);
    return FALSE;
  }

  $row = mysqli_fetch_assoc($result);
  if( !isset($row['popis'])){
    header("Location: ./course.php?id=$id&err=notfound");
    exit();
  }

  if( check_view_or_edit_event($row) ){
    echo("<h2>Smazat termín</h2>
        <form action='act.event_delete.php' method='post'>
        <input type='hidden' name='id' value='$id'>
        <input type='hidden' name='date' value='$date'>
        <input type='hidden' name='time' value='$time'>
        <input type='hidden' name='room' value='$room'>
        <button type='submit' name='submit_delete_event'>Smazat termín</button>
        </form>");
  }
}

function show_all_pending_student_registrations($id, $db){
  if($_SESSION['role'] == 5){
    $where = "";
  }else{
    $where = "WHERE garant_ID = '$id' OR vedouci_ID = '$id'";
  }

  $query = "SELECT ke_schvaleni_student.Kurzy_ID, nazev, jmeno, prijmeni, email, student_ID  FROM ke_schvaleni_student 
                                                    JOIN uzivatele ON student_ID = Uzivatele_ID 
                                                    JOIN kurzy ON kurzy.Kurzy_ID = ke_schvaleni_student.Kurzy_ID
                                                    $where
                                                    ORDER BY Kurzy_ID, prijmeni, jmeno ASC";
  
  $result = mysqli_query($db, $query);
  if($result == FALSE){
    echo("CHYBA SQL ".$query);
    return FALSE;
  }
  if(mysqli_num_rows( $result ) === 0){
    return;
  }

  echo("<b>®adatelé o úèast ve Va¹ich kurzech:</b></br><table><tr><th>Kurz</th><th>Název</th><th>®adatel</th><th></th></tr>");
  while($row = mysqli_fetch_assoc($result)){
    $course_id = htmlspecialchars($row['Kurzy_ID']);
    $nazev = htmlspecialchars($row['nazev']);
    $zadatel = htmlspecialchars($row['prijmeni'] .", " . $row['jmeno']) . " (<a href='mailto:".$row['email']."'>".$row['email']."</a>)";
    $confirm = "<form action='act.course_register_confirm.php' method='post' style='margin:0; float: right;'>
                  <input type='hidden' name='student_id' value='".$row['student_ID']."'>
                  <input type='hidden' name='course_id' value='$course_id'>
                  <button type='submit' name='submit_confirm_student_reg'>Schválit</button>
                  <button type='submit' name='submit_reject_student_reg'>Zamítnout</button>
                </form>";
    echo("<tr><td><b>$course_id</b></td><td><a href='./course?id=$course_id'>$nazev</a></td><td>$zadatel</td><td>$confirm</td></tr>"); 
  }
  echo("</table><br>");
}

function show_pending_student_registrations($course_id, $id){
  $where = "WHERE Kurzy_ID = '$course_id'";
  if($_SESSION['role'] != 5){
    $where .= "AND ( garant_ID = '$id' OR vedouci_ID = '$id' )";
  }

  $query = "SELECT jmeno, prijmeni, email, student_ID  FROM ke_schvaleni_student 
                                                    JOIN uzivatele ON student_ID = Uzivatele_ID 
                                                    $where
                                                    ORDER BY prijmeni, jmeno ASC";
  require('dbh.php');
  $result = mysqli_query($db, $query);
  if($result == FALSE){
    echo("CHYBA SQL ".$query);
    return FALSE;
  }
  if(mysqli_num_rows( $result ) === 0){
    return;
  }

  echo("<br><h3>®adatelé o úèast:</h3><table><tr><th>®adatel</th><th></th></tr>");
  while($row = mysqli_fetch_assoc($result)){
    $zadatel = htmlspecialchars($row['prijmeni'] .", " . $row['jmeno']) . " (<a href='mailto:".htmlspecialchars($row['email'])."'>".htmlspecialchars($row['email'])."</a>)";
    $confirm = "<form action='act.course_register_confirm.php' method='post' style='margin:0; float: right;'>
                  <input type='hidden' name='student_id' value='".$row['student_ID']."'>
                  <input type='hidden' name='course_id' value='$course_id'>
                  <button type='submit' name='submit_confirm_student_reg'>Schválit</button>
                  <button type='submit' name='submit_reject_student_reg'>Zamítnout</button>
                </form>";
    echo("<tr><td>$zadatel</td><td>$confirm</td></tr>"); 
  }
  echo("</table><br>");
}
?>