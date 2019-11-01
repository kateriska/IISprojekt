<?php
function show_student_requests($user_id, $db)
{
  $query = "SELECT * FROM zapsane_kurzy, kurzy, uzivatele WHERE zapsane_kurzy.Kurzy_ID = kurzy.Kurzy_ID AND kurzy.garant_ID = '$user_id' AND uzivatele.Uzivatele_ID = '$user_id'";
  $result = mysqli_query($db, $query);
  if ($result->num_rows > 0) {
    echo "<b>®ádosti studentù o zapsaní do kurzu:</b>";
    echo"<table>";
      echo"<tr>";
        echo"<th>Zkratka kurzu</th>";
        echo"<th>ID studenta</th>";
      echo"</tr>";
    while($row = $result->fetch_assoc())
    {
      $course_id =  htmlspecialchars($row['Kurzy_ID']);
      $student_id =  htmlspecialchars($row['student_ID']);
      echo "<tr><td><a href='./course?id=$course_id'>$course_id</a></td><td><b>$student_id</b></td></tr>";
    }
    echo "</table>";
  }

  echo "<br />";
}

/*
require_once("dbh.php");
echo "Výpis ¾ádosti:\n";
echo "<br />";
show_student_requests(3, $db);
*/

?>
