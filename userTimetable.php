<?php

// select for student who have some courses
  function show_my_timetable_student($user_id, $db)
  {
    $query = "SELECT * FROM terminy, kurzy, zapsane_kurzy, uzivatele WHERE zapsane_kurzy.student_ID = '$user_id' AND zapsane_kurzy.Kurzy_ID = kurzy.Kurzy_ID AND zapsane_kurzy.student_ID = uzivatele.Uzivatele_ID AND uzivatele.Uzivatele_ID = '$user_id' AND zapsane_kurzy.Kurzy_ID = terminy.Kurzy_ID ORDER BY terminy.datum ASC";
    $result = mysqli_query($db, $query);
    if ($result->num_rows > 0) {
      echo "<b>Va¹e termíny:</b>";
      echo"<table>";
        echo"<tr>";
          echo"<th>Zkratka kurzu</th>";
          echo"<th>Datum konání termínu</th>";
          echo"<th>Èas konání termínu</th>";
          echo"<th>Místnost</th>";
          echo"<th>Typ termínu</th>";
          echo"<th>Doba trvání termínu</th>";
        echo"</tr>";
      while($row = $result->fetch_assoc())
      {
        $course_id =  htmlspecialchars($row['Kurzy_ID']);
        $date =  htmlspecialchars($row['datum']);
        $time =  htmlspecialchars($row['cas']);
        $time_cut = substr($time,0,5);
        $place =  htmlspecialchars($row['mistnost_ID']);
        $type =  htmlspecialchars($row['typ_termin']);
        $length = htmlspecialchars($row['doba_trvani']);
        if ($length == 0)
        {
          $length = '';
        }
        else
        {
            $length = $length." min";
        }
        echo "<tr><td><a href='./course?id=$course_id'>$course_id</a></td><td><b>$date</b></td><td><b>$time_cut</b></td><td><b>$place</b></td><td><a href='./event?id=$course_id&d=$date&t=$time&r=$place'>$type</a></td><td><b>$length</b></td></tr>";
      }
      echo "</table>";
  }
}

function show_my_timetable_lecturer($user_id, $db)
{
  $query = "SELECT * FROM terminy, kurzy, zapsane_kurzy, uzivatele WHERE zapsane_kurzy.student_ID = '$user_id' AND zapsane_kurzy.Kurzy_ID = kurzy.Kurzy_ID AND zapsane_kurzy.student_ID = uzivatele.Uzivatele_ID AND uzivatele.Uzivatele_ID = '$user_id' AND zapsane_kurzy.Kurzy_ID = terminy.Kurzy_ID ORDER BY terminy.datum ASC";
  $result = mysqli_query($db, $query);
  if ($result->num_rows > 0) {
    echo "<b>Va¹e studentské termíny:</b>";
    echo"<table>";
      echo"<tr>";
        echo"<th>Zkratka kurzu</th>";
        echo"<th>Datum konání termínu</th>";
        echo"<th>Èas konání termínu</th>";
        echo"<th>Místnost</th>";
        echo"<th>Typ termínu</th>";
        echo"<th>Doba trvání termínu</th>";
      echo"</tr>";
    while($row = $result->fetch_assoc())
    {
      $course_id =  htmlspecialchars($row['Kurzy_ID']);
      $date =  htmlspecialchars($row['datum']);
      $time =  htmlspecialchars($row['cas']);
      $time_cut = substr($time,0,5);
      $place =  htmlspecialchars($row['mistnost_ID']);
      $type =  htmlspecialchars($row['typ_termin']);
      $length = htmlspecialchars($row['doba_trvani']);
      if ($length == 0)
      {
        $length = '';
      }
      else
      {
          $length = $length." min";
      }
      echo "<tr><td><a href='./course?id=$course_id'>$course_id</a></td><td><b>$date</b></td><td><b>$time_cut</b></td><td><b>$place</b></td><td><a href='./event?id=$course_id&d=$date&t=$time&r=$place'>$type</a></td><td><b>$length</b></td></tr>";
    }
    echo "</table>";
}

$query = "SELECT * FROM terminy, kurzy, uzivatele WHERE terminy.lektor_ID = '$user_id' AND terminy.Kurzy_ID = kurzy.Kurzy_ID AND uzivatele.Uzivatele_ID = '$user_id' ORDER BY terminy.datum ASC";
$result = mysqli_query($db, $query);
if ($result->num_rows > 0) {
  echo "<b>Va¹e lektorské termíny:</b>";
  echo"<table>";
    echo"<tr>";
      echo"<th>Zkratka kurzu</th>";
      echo"<th>Datum konání termínu</th>";
      echo"<th>Èas konání termínu</th>";
      echo"<th>Místnost</th>";
      echo"<th>Typ termínu</th>";
      echo"<th>Doba trvání termínu</th>";
    echo"</tr>";
  while($row = $result->fetch_assoc())
  {
    $course_id =  htmlspecialchars($row['Kurzy_ID']);
    $date =  htmlspecialchars($row['datum']);
    $time =  htmlspecialchars($row['cas']);
    $time_cut = substr($time,0,5);
    $place =  htmlspecialchars($row['mistnost_ID']);
    $type =  htmlspecialchars($row['typ_termin']);
    $length = htmlspecialchars($row['doba_trvani']);
    if ($length == 0)
    {
      $length = '';
    }
    else
    {
        $length = $length." min";
    }
    echo "<tr><td><a href='./course?id=$course_id'>$course_id</a></td><td><b>$date</b></td><td><b>$time_cut</b></td><td><b>$place</b></td><td><a href='./event?id=$course_id&d=$date&t=$time&r=$place'>$type</a></td><td><b>$length</b></td></tr>";
  }
  echo "</table>";
}
}

  /*
  require_once("dbh.php");
  show_my_timetable_student(5, $db);
  show_my_timetable_lecturer(4, $db);
  show_my_timetable_lecturer(8, $db);
  */




?>
