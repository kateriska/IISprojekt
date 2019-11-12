<?php

$course_id = $_POST['course_id'];
$user_id = $_POST['student_id'];

if($_POST['from_index'] == 1){
  $location = "Location: ./index.php?p=np";
}else{
  $location = "Location: ./course.php?id=$course_id";
}


if(isset($_POST['submit_confirm_student_reg'])){
  $query = "INSERT INTO zapsane_kurzy (Kurzy_ID, student_ID)
                                VALUES ('$course_id', '$user_id')";
  require('dbh.php');
  $result = mysqli_query($db, $query);
  if($result == FALSE){
    header($location."&err=isql");
    exit();
  }
  $query = "DELETE FROM ke_schvaleni_student WHERE Kurzy_ID='$course_id' AND student_ID='$user_id'";
  $result = mysqli_query($db, $query);
  if($result == FALSE){
    header($location."&err=disql");
    exit();
  }else{
    header($location."&succ=confirmed");
    exit();
  }

}else if(isset($_POST['submit_reject_student_reg'])){
  $query = "DELETE FROM ke_schvaleni_student WHERE Kurzy_ID='$course_id' AND student_ID='$user_id'";
  require('dbh.php');
  $result = mysqli_query($db, $query);
  if($result == FALSE){
    header($location."&err=sql");
    exit();
  }else{
    header($location."&succ=deleted");
    exit();
  }

}else{
  header("Location: ./index.php");
  exit();
}