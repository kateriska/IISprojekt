<html>
<head>
  <link rel="stylesheet" href="style.css">
  <?php 
    require_once('fn.elements.php');  
  ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>


<body>
<?php
  session_start();  
  insert_login_bar();
?>

  <container class="center">
  <?php 
    $course = $_GET['id'];
    $date = $_GET['d'];
    $time = $_GET['t'];
    $room = $_GET['r'];
    $me = $_SESSION['user_id'];
    if( !check_for_adding_marks($course, $date, $time, $room, $me) || !isset($_GET['id']) || !isset($_GET['t']) || !isset($_GET['d']) || !isset($_GET['r'])){
      header("Location: ./index.php");
      exit();
    }

    $query = "SELECT jmeno, prijmeni, Uzivatele_ID FROM zapsane_kurzy JOIN uzivatele ON student_ID=Uzivatele_ID WHERE Kurzy_ID='$course'";

    require("dbh.php");
    $result = mysqli_query($db, $query);
    

    echo("<table><tr><th>Student</th><th>Hodnocení</th></tr>");
    $cnt = 0;
    while($row = mysqli_fetch_assoc($result)){
      $user_name = $row['Uzivatele_ID'];
      $mark_query = "SELECT hodnoceni FROM hodnoceni WHERE student_ID='$user_name' AND datum='$date' AND cas='$time' AND mistnost_ID='$room' Kurzy_ID='$course'";
      $result = mysqli_query($db, $mark_query);
      $mark_row = mysqli_fetch_assoc($db, $mark_query);
      if(mysqli_num_rows($result) == 0){
        $val = 0;
      }else{
        $val = $mark_row['hodnoceni'];
      }
      
      $cnt++;
      $name = htmlspecialchars($row['prijmeni'] .", ". $row['jmeno']);
      $marks = "<input type='number' min='0' max='100' name='$cnt' value='$val' form='marks'>";
      echo("<tr><td>$name</td><td>$marks</td></tr>");
    }
    echo("</table><br>
          <form method='post' action='act.marks_submit'>
            <input type='hidden' name='author' value='$me'>
            <input type='hidden' name='cnt' value='$cnt'>
            <button type='submit' name='submit_marks'>Ulo¾it hodnocení</button>
          </form>");
    require_once("fn.elements.php");
    insert_reverse_tile("Zpìt na termín", "./event?id=$course&d=$date&t=$time&r=$room");
  ?>
  </container>
</body>

</html>