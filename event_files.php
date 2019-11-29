<?php
function get_event_files($id, $date, $time, $room)
{
  require("dbh.php");
  $id = $_GET['id'];
  $date = $_GET['d'];
  $time = $_GET['t'];
  $room = $_GET['r'];
  $query = "SELECT * FROM soubory WHERE soubory.Kurzy_ID = '$id' AND soubory.datum = '$date' AND soubory.cas = '$time' AND soubory.mistnost_ID = '$room'";
  $result = mysqli_query($db, $query);
  if ($result->num_rows > 0) {
    echo"<table>";
      echo"<tr>";
        echo"<th>Soubory k termínu:</th>";
      echo"</tr>";
    while($row = $result->fetch_assoc())
    {
      $filename =  htmlspecialchars($row['nazev_souboru']);
      echo "<tr><td><a href='./event_files/$filename'>$filename</a></td></tr>";
    }
    echo "</table><br>";
  }
}

//get_event_files('IMD', '2019-11-28', '15:00:00.000000', 'G505', $db );

?>
