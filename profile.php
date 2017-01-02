<?php
  session_start();
  
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

  } else {
    header("location: login.php");
  }
?>

<!DOCTYPE html>
<html>
  <head>
	  <meta charset="UTF-8">
	  <title> Register Page </title>
     
	  <!-- Bootstrap Css -->
	  <link rel="stylesheet" href="css/bootstrap.min.css">
	  <!-- Custom Css -->
	  <link rel="stylesheet" href="css/profile.css">     
  </head>
  <body>

  	<nav class="navbar navbar-inverse navbar-fixed-top">
  	  <div class="container">
    		<div class="navbar-header">
    		  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
    			<span class="sr-only">Toggle navigation</span>
    			<span class="icon-bar"></span>
    			<span class="icon-bar"></span>
    			<span class="icon-bar"></span>
    		  </button>
    		  <a class="navbar-brand" style="color:white;" href="#">Ticket Sale Platform</a>
    		</div>
     
     
    		<div id="navbar" class="collapse navbar-collapse">
    		  <ul class="nav navbar-nav">
	  		    <li class="active"><a href="">My Reservations</a></li>
    			  <li><a href="/activities.php">Activities</a></li>
            <li><a href="/search.php">Search </a></li>
    		  </ul>
            
          <ul class="nav navbar-nav navbar-right">
            <li class="nav-item"><a href="/logout.php">Logout</a></li>
          </ul>    
    		</div>
         
 	    </div>
    </nav>
    
    <div class="col-md-2"></div>
    <div class="col-md-7">
      <table class='table table-striped table-hover'>
       <thead>
         <tr>
           <th> ID </th>
           <th> Activity Name </th>
           <th> Type </th>
           <th> Showroom </th>
           <th> City </th>
           <th> Date </th>
           <th> Ticket Amount </th>
           <th> </th>
           <th> Update </th>
           <th></th>
           <th> Cancel </th>
         </tr>
       </thead>
       <tbody>
       
<?php
    include("config.php");
    
    $userID = $_SESSION["userID"];
    $searchSql = "SELECT ID, eventID, ticketNumber FROM reservation WHERE userID='$userID' ORDER BY eventID ASC";
    $result = mysqli_query($db,$searchSql);
    
    if ($result->num_rows > 0) {
       // output data of each row
       while($row = $result->fetch_assoc()) {
         $reservationID = $row["ID"];
         $eventID = $row["eventID"];
         $ticketCount = $row["ticketNumber"];
         $eventSql = "SELECT * FROM event WHERE ID='$eventID'";
         $eventResult = mysqli_query($db,$eventSql);
         if ($eventResult->num_rows > 0) {
           // output data of each row
           while($eventRow = $eventResult->fetch_assoc()) {
             $activityID = $eventRow["activityID"];
             $showroomID = $eventRow["showroomID"];
             
             $activitySql = "SELECT * FROM activity WHERE ID = '$activityID'";  
             $activityResult = $db->query($activitySql);
             $activityRow = $activityResult->fetch_assoc();
             
             $showroomSql = "SELECT * FROM showroom WHERE ID = '$showroomID'";  
             $showroomResult = $db->query($showroomSql);
             $showroomRow = $showroomResult->fetch_assoc();       
             
             
             echo "<tr>";
             echo "<td>" . $eventRow["ID"] . "</td>";
             echo "<td>" . $activityRow["activityName"] . "</td>";
             echo "<td>" . $activityRow["type"] . "</td>";
             echo "<td>" . $showroomRow["showroomName"] . "</td>";
             echo "<td>" . $showroomRow["city"] . "</td>";
             echo "<td>" . $eventRow["date"] . "</td>";
             echo "<form action='update.php' method='post' role='form'>";
             echo "<td><input type='text' name='ticketCount' class='form-control' placeholder='$ticketCount' style='width:100px;'></input></td>";
             echo "<td><input name='reservationID' type='hidden' value='$reservationID' style='width:1px;'></input></td>";
             echo "<td><button type='submit' name='ticket-update' class='btn btn-primary'>Update</button></td>";
             echo "</form>";
             echo "<form action='cancel.php' method='post' role='form'>";
             echo "<td><input name='reservationID' type='hidden' value='$reservationID' style='width:1px;'></input></td>";
             echo "<td><button type='submit' name='ticket-cancel' class='btn btn-danger'>Cancel</button></td>";
             echo "</form>";
             echo "</tr>";
           }
         }
         
         
       }
   }
  
?>   
      </tbody>
    </table>
    </div> 
  </body>
</html>   
       