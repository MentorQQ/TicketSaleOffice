<?php
  
  include("config.php");
  session_start();

  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  
  } else {
    header("location: login.php");
  }

  if(isset($_POST['ticket-submit'])) {
    $eventID = $_POST['eventID'];
    $ticketCount = $_POST['ticketCount'];
    $userID = $_SESSION["userID"];
    
    if(!empty($ticketCount)){
      $searchSql = "SELECT * FROM reservation WHERE userID = '$userID' AND eventID = '$eventID'";
      $result = mysqli_query($db,$searchSql);
      $rowCount = mysqli_num_rows($result);
      
      if($rowCount == 1) {
        $updateSql = "UPDATE reservation SET ticketNumber='$ticketCount' WHERE userID = '$userID' AND eventID = '$eventID'";
        mysqli_query($db,$updateSql);  
        header("location: search.php");
      } elseif ($rowCount == 0) {
        $insertSql = "INSERT INTO reservation(userID, eventID, ticketNumber) VALUES ('$userID','$eventID','$ticketCount')";
        mysqli_query($db,$insertSql);
        header("location: search.php");
      } else {
        header("location: search.php");
      }   
    }  
  }
  
?>    
  