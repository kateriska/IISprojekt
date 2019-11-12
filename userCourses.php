<?php
function show_my_courses_garant($user_id, $db)
{
  $query = "SELECT * FROM kurzy, uzivatele WHERE kurzy.garant_ID = '$user_id' AND uzivatele.Uzivatele_ID = '$user_id'";
  $result = mysqli_query($db, $query);
  if ($result->num_rows > 0) {
    echo "<b>Vámi garantované kurzy:</b>";
    echo"<table>";
      echo"<tr>";
        echo"<th>Zkratka kurzu</th>";
        echo"<th>Název kurzu</th>";
        echo"<th>Typ kurzu</th>";
      echo"</tr>";
    while($row = $result->fetch_assoc())
    {
      $course_id =  htmlspecialchars($row['Kurzy_ID']);
      $nazev =  htmlspecialchars($row['nazev']);
      $typ =  htmlspecialchars($row['typ']);
      echo "<tr><td><b>$course_id</b></td><td><a href='./course?id=$course_id'>$nazev</a></td><td>$typ</td></tr>";
    }
    echo "</table>";
  }

  echo "<br />";
}
function show_my_courses_lecturer($user_id, $db)
{
  $query = "SELECT * FROM kurzy, terminy, uzivatele WHERE terminy.lektor_ID = '$user_id' AND terminy.Kurzy_ID = kurzy.Kurzy_ID AND terminy.lektor_ID = uzivatele.Uzivatele_ID AND uzivatele.Uzivatele_ID = '$user_id'";
  $result = mysqli_query($db, $query);
  if ($result->num_rows > 0) {
    echo "<b>Vámi vyuèované kurzy:</b>";
    echo"<table>";
      echo"<tr>";
        echo"<th>Zkratka kurzu</th>";
        echo"<th>Název kurzu</th>";
        echo"<th>Typ kurzu</th>";
      echo"</tr>";
    while($row = $result->fetch_assoc())
    {
      $course_id =  htmlspecialchars($row['Kurzy_ID']);
      $nazev =  htmlspecialchars($row['nazev']);
      $typ =  htmlspecialchars($row['typ']);
      echo "<tr><td><b>$course_id</b></td><td><a href='./course?id=$course_id'>$nazev</a></td><td>$typ</td></tr>";
    }
    echo "</table><br>";
  }
}
function show_my_courses_student($user_id, $db)
{
  $query = "SELECT * FROM kurzy, zapsane_kurzy, uzivatele WHERE zapsane_kurzy.student_ID = '$user_id' AND zapsane_kurzy.Kurzy_ID = kurzy.Kurzy_ID AND zapsane_kurzy.student_ID = uzivatele.Uzivatele_ID AND uzivatele.Uzivatele_ID = '$user_id'";
  $result = mysqli_query($db, $query);
  if ($result->num_rows > 0) {
    echo "<b>Va¹e zapsané kurzy:</b>";
    echo"<table>";
      echo"<tr>";
        echo"<th>Zkratka kurzu</th>";
        echo"<th>Název kurzu</th>";
        echo"<th>Typ kurzu</th>";
      echo"</tr>";
    while($row = $result->fetch_assoc())
    {
      $course_id =  htmlspecialchars($row['Kurzy_ID']);
      $nazev =  htmlspecialchars($row['nazev']);
      $typ =  htmlspecialchars($row['typ']);
      echo "<tr><td><b>$course_id</b></td><td><a href='./course?id=$course_id'>$nazev</a></td><td>$typ</td></tr>";
    }
    echo "</table><br>";
  }
}

function show_my_courses_vedouci($user_id, $db)
{
  $query = "SELECT * FROM kurzy, uzivatele WHERE kurzy.vedouci_ID = '$user_id' AND uzivatele.Uzivatele_ID = '$user_id'";
  $result = mysqli_query($db, $query);
  if ($result->num_rows > 0) {
    echo "<b>Vámi vedené kurzy:</b>";
    echo"<table>";
      echo"<tr>";
        echo"<th>Zkratka kurzu</th>";
        echo"<th>Název kurzu</th>";
        echo"<th>Typ kurzu</th>";
      echo"</tr>";
    while($row = $result->fetch_assoc())
    {
      $course_id =  htmlspecialchars($row['Kurzy_ID']);
      $nazev =  htmlspecialchars($row['nazev']);
      $typ =  htmlspecialchars($row['typ']);
      echo "<tr><td><b>$course_id</b></td><td><a href='./course?id=$course_id'>$nazev</a></td><td>$typ</td></tr>";
    }
    echo "</table>";
  }

  echo "<br />";
}

/*
require_once("dbh.php");
echo "Výpis pro garanta:\n";
echo "<br />";
show_my_courses_garant(9, $db);
echo "Výpis pro lektora:\n";
echo "<br />";
show_my_courses_lecturer(4, $db);
echo "Výpis pro studenta:\n";
echo "<br />";
show_my_courses_student(5, $db);
echo "Výpis pro vedoucího:\n";
echo "<br />";
show_my_courses_vedouci(8, $db);
*/

?>
