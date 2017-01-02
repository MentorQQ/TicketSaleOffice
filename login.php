<?php
  include("config.php");

  if($_SERVER["REQUEST_METHOD"] == "POST") {
      if (isset($_POST['login-submit'])) {
        session_start();
        
        $myusername = mysqli_real_escape_string($db,$_POST['username']);
        $mypassword = mysqli_real_escape_string($db,$_POST['password']);
  
        $sql = "SELECT ID FROM user WHERE username = '$myusername' and password = '$mypassword'";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  
        $count = mysqli_num_rows($result);
  
        // If result matched $myusername and $mypassword, table row must be 1 row
  
        if($count == 1) {
           
           $_SESSION['login_user'] = $myusername;
           $_SESSION['userID'] = $row['ID'];
           $_SESSION['loggedin'] = true;
           header("location: activities.php");
        } else {
           $errorMessage = "Your Login Name or Password is invalid";
        }
      }
      elseif (isset($_POST['register-submit'])) {
        session_start();
        
        $error = false;
        
        $name = mysqli_real_escape_string($db,$_POST['register-username']);
        $email = mysqli_real_escape_string($db,$_POST['register-email']);
        $pass = mysqli_real_escape_string($db,$_POST['register-password']);  
        
        if (empty($name)) {
          $error = true;
          $nameError = "Please enter your full name.";
        } else if (strlen($name) < 3) {
          $error = true;
          $nameError = "Name must have atleast 3 characters.";
        } else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
          $error = true;
          $nameError = "Name must contain alphabets and space.";
        } else {
          // check username exist or not
          $query = "SELECT ID FROM user WHERE username='$name'";
          $result = mysqli_query($db,$query);
          $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
          $active = $row['active'];
          $count = mysqli_num_rows($result);
          
          if($count!=0){
            $error = true;
            $nameError = "Provided username is already in use.";
          }
        }
        
        if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
          $error = true;
          $emailError = "Please enter valid email address.";
        } else {
          // check email exist or not
          $query = "SELECT ID FROM user WHERE email='$email'";
          $result = mysqli_query($db,$query);
          $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
          $active = $row['active'];
          $count = mysqli_num_rows($result);
          
          if($count!=0){
            $error = true;
            $emailError = "Provided Email is already in use.";
          }
        }
        
        if (empty($pass)){
         $error = true;
         $passError = "Please enter password.";
        } else if(strlen($pass) < 6) {
         $error = true;
         $passError = "Password must have atleast 6 characters.";
        }
        
        $password = hash('sha256', $pass);
        
        if( !$error ) {
         
         $query = "INSERT INTO user(username , email, password) VALUES('$name', '$email','$pass')";
         $res = mysqli_query($db,$query);
          
         if ($res) {
          $successMessage = "Successfully registered, you may login now";
          unset($name);
          unset($pass);
         } else {
          $errorMessage = "Something went wrong, try again later..."; 
         }   
        }
        
      }

     
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
	  <link rel="stylesheet" href="css/form.css">
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
  		  <a class="navbar-brand" href="#">Ticket Sale Platform</a>
  		</div>
  		<div id="navbar" class="collapse navbar-collapse">
  		  <ul class="nav navbar-nav">
  			<li class="active"><a href="#">Register / Login</a></li>
  			<li><a href="/activities.php">Activities</a></li>
  		  </ul>
  		</div>
  	  </div>
  	</nav>

  	<div class="container">
        <div class="row">
  		<div class="col-md-6 col-md-offset-3">
  		  <div class="panel panel-login">
  			<div class="panel-heading">
  			  <div class="row">
  				<div class="col-xs-6">
  				  <a href="#" class="active" id="login-form-link">Login</a>
  				</div>
  				<div class="col-xs-6">
  				<a href="#" id="register-form-link">Register</a>
  				</div>
  			  </div>
  			  <hr>
  			</div>
  			<div class="panel-body">
  			  <div class="row">
  			    <div class="col-lg-12">
                     
              <!-- Login -->         
    				  <form id="login-form" action="" method="post" role="form" style="display: block;">
    				    <div class="form-group">
    					    <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
    					  </div>
      					<div class="form-group">
      					  <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
      					</div>
    					  <div class="form-group">
    					    <div class="row">
    					      <div class="col-sm-6 col-sm-offset-3">
    						      <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
    						    </div>
    					    </div>
    					  </div>         
  				    </form>
                                   
              
              <!-- Register -->
    				  <form id="register-form" action="" method="post" role="form" style="display: none;">
                <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $nameError; ?></div>
    				    <div class="form-group">
    					    <input type="text" name="register-username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
    					  </div>
                <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $emailError; ?></div>
                <div class="form-group">
      					  <input type="email" name="register-email" id="email" tabindex="2" class="form-control" placeholder="Email">
      					</div>   
                <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $passError; ?></div>                
      					<div class="form-group">
      					  <input type="password" name="register-password" id="password" tabindex="3" class="form-control" placeholder="Password">
      					</div>
    					  <div class="form-group">
    					    <div class="row">
    						    <div class="col-sm-6 col-sm-offset-3">
  						        <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
  						      </div>
  					      </div>
  					    </div>
  				    </form>
                   
              <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $errorMessage; ?></div>   
              <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $successMessage; ?></div> 
                          
			      </div>
			    </div>
			  </div>
      </div>
    </div>
  </div>
</div>

	<!-- JQuery File -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<!-- Bootstrap Js File -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Form js -->
	<script src="js/form.js"></script>
</body>
</html>
