<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = 'Please enter username.';
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST['password']))){
        $password_err = 'Please enter your password.';
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT username, password FROM users WHERE username = ? AND password = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
          
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
        
            $param_username = $username;
            $param_password = $password;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
              
                if(mysqli_stmt_num_rows($stmt) == 1){ 
					session_start();
					$_SESSION['username'] = $username;      
					header("location: individ.html");              
                } else{
                    
                    $username_err = 'No account found with that username.';
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
                     
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link   href="CSS/reset.css"
            rel="stylesheet"
            type="text/css">
    
    <link   href="CSS/main.css"
            rel="stylesheet"
            type="text/css">
    
    
</head>
<body style="background-image: url(a.jpg)"> 
    
    <ul>
  <li><a class="active" href="index.html">Home</a></li>
  <li><a href="recept.html">Recepies</a></li>
  <li><a href="calender.html">Calender</a></li>
  <li><a href="file_name.php">Log in / Sign up</a></li>
</ul>

	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		<div <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
			<label><b>Username:</b>
            <sup>*</sup></label>
			<input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
			<span><?php echo $username_err; ?></span>
		</div>    
<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
			<label><b>Password:</b><sup>*</sup></label>
			<input type="password" name="password" class="form-control">
			<span ><?php echo $password_err; ?></span>
		</div>
		      <div class="form-group">
			 <input type="submit" class="btn btn-primary" value="Submit">
		</div>
	  
	</form>
     
</body>
</html>