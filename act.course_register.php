<?php

$course_id = $_POST['id_course'];
$user_id = $_POST['id_user'];

if(!isset($_POST['submit_register'])){
  header("Location: ./course.php?id=$course_id&err=inv_access");
  exit();
}

$query = "INSERT INTO ke_schvaleni_student (Kurzy_ID, student_ID) 
                                    VALUES ('$course_id', '$user_id')";

require('dbh.php');
$result = mysqli_query($db, $query);
if($result == FALSE){
  header("Location: ./course.php?id=$course_id&err=sql");
}else{
  header("Location: ./course.php?id=$course_id&succ=signed");
}

exit();

?>