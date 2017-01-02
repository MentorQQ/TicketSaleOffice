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
	  <link rel="stylesheet" href="css/activity.css">
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
	  		    <li><a href="/profile.php">My Reservations</a></li>
    			  <li class="active"><a href="">Activities</a></li>
            <li><a href="/search.php">Search </a></li>
    		  </ul>
            
          <ul class="nav navbar-nav navbar-right">
            <li class="nav-item"><a href="/logout.php">Logout</a></li>
          </ul>    
    		</div>
         
 	    </div>
    </nav>
    <div class="col-md-3"></div>
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
         </tr>
       </thead>
       <tbody>

<?php
   include('config.php');
   
   $sql = "SELECT * FROM event";
   $result = $db->query($sql);
          

   if ($result->num_rows > 0) {
    // output data of each row
     while($row = $result->fetch_assoc()) {
       $activityID = $row["activityID"];
       $showroomID = $row["showroomID"];
       
       $activitySql = "SELECT * FROM activity WHERE ID = '$activityID'";  
       $activityResult = $db->query($activitySql);
       $activityRow = $activityResult->fetch_assoc();
       
       $showroomSql = "SELECT * FROM showroom WHERE ID = '$showroomID'";  
       $showroomResult = $db->query($showroomSql);
       $showroomRow = $showroomResult->fetch_assoc();       
       
       
       echo "<tr>";
       echo "<td>" . $row["ID"] . "</td>";
       echo "<td>" . $activityRow["activityName"] . "</td>";
       echo "<td>" . $activityRow["type"] . "</td>";
       echo "<td>" . $showroomRow["showroomName"] . "</td>";
       echo "<td>" . $showroomRow["city"] . "</td>";
       echo "<td>" . $row["date"] . "</td>";
       echo "</tr>";
     }
   } else {
    echo "0 results";
   }
?>


      </tbody>
    </table>
    </div> 
  </body>
</html>