<?php
// Include config file
require_once 'config.php';
 ?>

<!DOCTYPE html>
<html> 
<head>
    <meta charset="utf-8">
    <title>Tasty Recipes</title>
    
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
  <li><a href="file_name.php">Log in / Log off</a></li>
</ul>
   
    <h2>Login Form</h2>

<form action="individ.html">

    <label><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" required>

    <label><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>
        
    <button type="submit">Login</button>
    <input type="checkbox" checked="checked"> Remember me
  </div>

  <div class="container" style="background-color:#f1f1f1">
    <button type="button" class="cancelbtn">Cancel</button>
    
  </div>
</form>
</body>

</html>