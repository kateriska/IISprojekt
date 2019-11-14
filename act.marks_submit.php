<?php
if( !isset($_POST['submit_marks']) ){
  header("Location: index.php");
  exit();
}

$inputs = $_POST['cnt'];
$course = $_POST['course'];
$date = $_POST['date'];
$time = $_POST['time'];
$room = $_POST['room'];
$me = $_POST['author'];

require("dbh.php");
for($i=1; $i<=$inputs; $i++){
  $student = $_POST["u$i"];
  $marks = $_POST["h$i"];
  echo("'$marks'");
  $query = "INSERT INTO hodnoceni (Kurzy_ID, datum, cas, mistnost_ID, student_ID, hodnoceni, hodnotil_ID)
                  VALUES ('$course', '$date', '$time', '$room', '$student', '$marks', '$me')";
  mysqli_query($db, $query);
  echo($query);
}

/*header("Location: ./marks.php?id=$course&d=$date&t=$time&r=$room");
exit();*/
?>