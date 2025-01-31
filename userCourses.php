<?php
function show_my_courses_garant($user_id, $db)
{
  $query = "SELECT * FROM kurzy, uzivatele WHERE kurzy.garant_ID = '$user_id' AND uzivatele.Uzivatele_ID = '$user_id'";
  $result = mysqli_query($db, $query);
  if ($result->num_rows > 0) {
    echo "<b>V�mi garantovan� kurzy:</b>";
    echo"<table>";
      echo"<tr>";
        echo"<th>Zkratka kurzu</th>";
        echo"<th>N�zev kurzu</th>";
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
function show_my_courses_lecturer($user_id, $db)
{
  $query = "SELECT * FROM kurzy, terminy, uzivatele WHERE terminy.lektor_ID = '$user_id' AND terminy.Kurzy_ID = kurzy.Kurzy_ID AND terminy.lektor_ID = uzivatele.Uzivatele_ID AND uzivatele.Uzivatele_ID = '$user_id'";
  $result = mysqli_query($db, $query);
  if ($result->num_rows > 0) {
    echo "<b>V�mi vyu�ovan� kurzy:</b>";
    echo"<table>";
      echo"<tr>";
        echo"<th>Zkratka kurzu</th>";
        echo"<th>N�zev kurzu</th>";
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
  $query = "SELECT Kurzy_ID, SUM(hodnoceni) hodnoceniSum FROM hodnoceni WHERE hodnoceni.student_ID = '$user_id' GROUP BY Kurzy_ID";
  $result = mysqli_query($db, $query);
  $hodnoceni_arr = array();
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc())
    {
      $course_id =  htmlspecialchars($row['Kurzy_ID']);
      $hodnoceni = htmlspecialchars($row['hodnoceniSum']);
      $hodnoceni_arr[$course_id] = $hodnoceni;
      $some_hodnoceni = true;
    }
  }
  else
  {
    $some_hodnoceni = false;
  }

  $query = "SELECT * FROM kurzy, zapsane_kurzy, uzivatele WHERE zapsane_kurzy.student_ID = '$user_id' AND zapsane_kurzy.Kurzy_ID = kurzy.Kurzy_ID AND zapsane_kurzy.student_ID = uzivatele.Uzivatele_ID AND uzivatele.Uzivatele_ID = '$user_id'";
  $result = mysqli_query($db, $query);
  $course_id_arr = array();
  $key_list_arr = array();
  if ($result->num_rows > 0) {
    echo "<b>Va�e zapsan� kurzy:</b>";
    echo"<table>";
      echo"<tr>";
        echo"<th>Zkratka kurzu</th>";
        echo"<th>N�zev kurzu</th>";
        echo"<th>Typ kurzu</th>";
        echo"<th>Hodnocen�</th>";
      echo"</tr>";
    while($row = $result->fetch_assoc())
    {
      $course_id =  htmlspecialchars($row['Kurzy_ID']);
      $nazev =  htmlspecialchars($row['nazev']);
      $typ =  htmlspecialchars($row['typ']);
      if ($some_hodnoceni == true)
      {
        foreach ($hodnoceni_arr as $key => $val) {
          array_push($key_list_arr, $key);
        }

        $keys = array_keys($hodnoceni_arr);
        foreach($keys as $key)
        {
          if ($course_id == $key && (!in_array($course_id, $course_id_arr)))
          {
            array_push($course_id_arr, $course_id);
            $body = $hodnoceni_arr[$key];
            echo "<tr><td><b>$course_id</b></td><td><a href='./course?id=$course_id'>$nazev</a></td><td>$typ</td></td><td>$body</td></tr>";
          }
          else if (!in_array($course_id, $key_list_arr))
          {
            $body = 0;
            echo "<tr><td><b>$course_id</b></td><td><a href='./course?id=$course_id'>$nazev</a></td><td>$typ</td></td><td>$body</td></tr>";
          }

        }
      }
      else
      {
        $body = 0;
        echo "<tr><td><b>$course_id</b></td><td><a href='./course?id=$course_id'>$nazev</a></td><td>$typ</td></td><td>$body</td></tr>";
      }
    }
    echo "</table><br>";
  }


}

function show_my_courses_vedouci($user_id, $db)
{
  $query = "SELECT * FROM kurzy, uzivatele WHERE kurzy.vedouci_ID = '$user_id' AND uzivatele.Uzivatele_ID = '$user_id'";
  $result = mysqli_query($db, $query);
  if ($result->num_rows > 0) {
    echo "<b>V�mi veden� kurzy:</b>";
    echo"<table>";
      echo"<tr>";
        echo"<th>Zkratka kurzu</th>";
        echo"<th>N�zev kurzu</th>";
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

/*
require_once("dbh.php");
echo "V�pis pro garanta:\n";
echo "<br />";
show_my_courses_garant(9, $db);
echo "V�pis pro lektora:\n";
echo "<br />";
show_my_courses_lecturer(4, $db);
echo "V�pis pro studenta:\n";
echo "<br />";
show_my_courses_student(6, $db);
echo "V�pis pro vedouc�ho:\n";
echo "<br />";
show_my_courses_vedouci(8, $db);
*/

?>
