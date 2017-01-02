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
  <body style="top-margin:90px">

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
    			  <li><a href="/activities.php">Activities</a></li>
            <li class="active"><a href="/search.php">Search </a></li>
    		  </ul>
            
          <ul class="nav navbar-nav navbar-right">
            <li class="nav-item"><a href="/logout.php">Logout</a></li>
          </ul>    
    		</div>
         
 	    </div>
    </nav>   
    
    <div class="col-md-3">
      <form method="post" role="form" class="form-horizontal">
        <fieldset>
          <legend align="center"> Search </legend>
          <div class="form-group">
            <label for="typeField" class="col-lg-2 control-label"> Type: </label>
            <div class="col-lg-8">
              <input type="text" class="form-control" name= "typeField" id="typeField" placeholder="Type">
            </div>
          </div>
          <div class="form-group">
            <label for="cityField" class="col-lg-2 control-label"> City: </label>
            <div class="col-lg-8">
              <input type="text" class="form-control" name= "cityField" id="cityField" placeholder="City">
            </div>
          </div>
          <div class="form-group">
            <label for="showroomField" class="col-lg-2 control-label"> Place: </label>
            <div class="col-lg-8">
              <input type="text" class="form-control" name="showroomField" id="showroomField" placeholder="Showroom">
            </div>
          </div>          
          <div class="form-group">
            <label for="dateStartField" class="col-lg-2 control-label"> Start: </label>
            <div class="col-lg-8">
              <input type="text" class="form-control" name="startField" id="dateStartField" placeholder="dd.mm.yy">
            </div>
          </div> 
          <div class="form-group">
            <label for="dateEndTime" class="col-lg-2 control-label"> End: </label>
            <div class="col-lg-8">
              <input type="text" class="form-control" name="endField" id="dateEndField" placeholder="dd.mm.yy">
            </div>  
          </div>                    
          <div class="form-group">
            <div class="col-lg-10 col-lg-offset-4">
              <button type="submit" name="search-submit" class="btn btn-primary">Search</button>
            </div>
          </div>   
        </fieldset>
      </form>    
    </div>
    
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
           <th> Ticket Number </th>
           <th></th>
           <th> Reservation </th>
         </tr>
       </thead>
       <tbody>
       
<?php 
  include('config.php');
  
  if (isset($_POST['search-submit'])) {
     
     $type = mysqli_real_escape_string($db,$_POST['typeField']);
     $city = mysqli_real_escape_string($db,$_POST['cityField']);
     $showroom = mysqli_real_escape_string($db,$_POST['showroomField']);
     $startTime = mysqli_real_escape_string($db,$_POST['startField']);
     $endTime = mysqli_real_escape_string($db,$_POST['endField']);
     
     if(empty($startTime) || empty($endTime)){
     
       $searchSql = "SELECT e.ID as ID, type, date, activityName, showroomName, city FROM event as e, activity a, showroom s WHERE e.activityID = a.ID AND e.showroomID = s.ID AND 
                    a.type LIKE '%$type%' AND s.city LIKE '%$city%' AND s.showroomName LIKE '%$showroom%' ORDER BY e.ID ASC";
       $searchResult = $db->query($searchSql);
       
       if ($searchResult->num_rows > 0) {
         // output data of each row
         while($row = $searchResult->fetch_assoc()) {
           $id = $row["ID"];
           echo "<tr>";
           echo "<td>" . $row["ID"] . "</td>";
           echo "<td>" . $row["activityName"] . "</td>";
           echo "<td>" . $row["type"] . "</td>";
           echo "<td>" . $row["showroomName"] . "</td>";
           echo "<td>" . $row["city"] . "</td>";
           echo "<td>" . $row["date"] . "</td>";
           echo "<form action='reservation.php' method='post' role='form'>";
           echo "<td><input type='text' name='ticketCount' class='form-control'></input></td>";
           echo "<td><input name='eventID' type='hidden' style='width:1px;' value='$id'></input></td>";
           echo "<td><button type='submit' id='$id' name='ticket-submit' class='btn btn-primary ticket-submit'>Reserve</button></td>";
           echo "</form>";
           echo "</tr>";
        }
      } else {
          echo "0 results";
      }
    } else {
    
      $searchSql = "SELECT e.ID as ID, type, date, activityName, showroomName, city FROM event as e, activity a, showroom s WHERE e.activityID = a.ID AND e.showroomID = s.ID AND 
                  a.type LIKE '%$type%' AND s.city LIKE '%$city%' AND s.showroomName LIKE '%$showroom%' AND 
                  STR_TO_DATE(date, '%d.%m.%y') BETWEEN STR_TO_DATE('$startTime', '%d.%m.%Y') AND STR_TO_DATE('$endTime', '%d.%m.%Y') ORDER BY e.ID ASC";                 
      $searchResult = $db->query($searchSql);
      
      if ($searchResult->num_rows > 0) {
        // output data of each row
        while($row = $searchResult->fetch_assoc()) {
          $id = $row["ID"];
          echo "<tr>";
          echo "<td>" . $row["ID"] . "</td>";
          echo "<td>" . $row["activityName"] . "</td>";
          echo "<td>" . $row["type"] . "</td>";
          echo "<td>" . $row["showroomName"] . "</td>";
          echo "<td>" . $row["city"] . "</td>";
          echo "<td>" . $row["date"] . "</td>";
          echo "<form action='reservation.php' method='post' role='form'>";
          echo "<td><input type='text' name='ticketCount' class='form-control'></input></td>";
          echo "<td><input name='eventID' type='hidden' value='$id'></input></td>";
          echo "<td><button type='submit' id='$id' name='ticket-submit' class='btn btn-primary ticket-submit'>Reserve</button></td>";
          echo "</form>";
          echo "</tr>";
       }
     } else {
         echo "0 results";
     } 
    }
  }
?>  
    
        </tbody>
      </table>  
    </div>    
  </body>
</html> 