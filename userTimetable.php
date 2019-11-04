<?php

// select for student who have some courses
  function show_my_timetable($user_id, $db)
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
        $place =  htmlspecialchars($row['mistnost_ID']);
        $type =  htmlspecialchars($row['typ_termin']);
        $length = htmlspecialchars($row['doba_trvani']);
        echo "<tr><td><a href='./course?id=$course_id'>$course_id</a></td><td><b>$date</b></td><td><b>$time</b></td><td><b>$place</b></td><td><b>$type</b></td><td><b>$length</b></td></tr>";
      }
      echo "</table>";
  }
}
  /*
  require_once("dbh.php");
  show_my_timetable(5, $db);
  */


?>
