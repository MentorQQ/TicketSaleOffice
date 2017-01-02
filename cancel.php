<?php
  include("config.php");
  session_start();
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

  } else {
    header("location: login.php");
  }

  if(isset($_POST['ticket-cancel'])) {
    $reservationID = $_POST["reservationID"];

    $cancelSql = "DELETE FROM reservation WHERE ID='$reservationID'";
    mysqli_query($db,$cancelSql);
    header("location: profile.php");
  }
 ?>
