<?php
  include("config.php");
  session_start();
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

  } else {
    header("location: login.php");
  }

  if(isset($_POST['ticket-update'])) {
    $reservationID = $_POST["reservationID"];
    $ticketCount = $_POST["ticketCount"];

    if(!empty($ticketCount)){
      $updateSql = "UPDATE reservation SET ticketNumber='$ticketCount' WHERE ID='$reservationID'";
      mysqli_query($db,$updateSql);
      header("location: profile.php");
    } else {
      header("location: profile.php");
    }  
  }
 ?>
