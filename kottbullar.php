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
    
    <style> 
    
        img{
            width: 385px;
            height: 327px;
            border-radius: 8px;
        }
    
    </style>

    <?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$comment = $comment_err = "";
 
session_start();
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && !empty(trim($_POST["new_comment"]))){  
    
    // Check if comment is empty
    if(empty(trim($_POST["new_comment"]))){
        $comment_err = 'Please enter comment.';
    } else{
        $comment = trim($_POST["new_comment"]);
    }
   
    $sql = "INSERT INTO comments (User, Article, Comment) Values(?,?,?)";
   
    if($stmt = mysqli_prepare($link, $sql)){
     
        mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_arctile, $param_comment);
   
        $param_username = $_SESSION['username'];
        $param_arctile = $_SERVER['REQUEST_URI'];
        $param_comment = $comment;
       
       
        if(mysqli_stmt_execute($stmt)){
           
        } else{
            echo "User not logged in!";
        }
        header("Refresh:0");
    }else{
        echo "Error!";
    }      
       
    mysqli_stmt_close($stmt);  
    $comment = "";
   
}
 
if($_SERVER["REQUEST_METHOD"] == "GET" && !empty(trim($_GET["user"])) && trim($_GET["user"]) == $_SESSION['username']){  
   
    $sql_delete = "DELETE FROM comments WHERE User=? AND Article=? AND Comment = ?;";
    if($stmt_delete = mysqli_prepare($link, $sql_delete)){
        mysqli_stmt_bind_param($stmt_delete, "sss", $param_user, $param_arct, $param_com);
        $param_user = trim($_GET["user"]);
        $param_arct = strtok($_SERVER["REQUEST_URI"],'?');
        $param_com = trim($_GET["Comment"]);
        mysqli_stmt_execute($stmt_delete); 
        header($param_arct);
        mysqli_stmt_close($stmt_delete);       
    }  
}
 
?>

    
</head>
<body style="background-image: url(a.jpg)">
    
    <ul>
  <li><a class="active" href="index.html">Home</a></li>
  <li><a href="recept.html">Recepies</a></li>
  <li><a href="calender.html">Calender</a></li>
 <li><a href="login.php">Log in / Log off</a></li>
</ul>


    <a href="kotbullar.html">
        <center><img src="1.jpg" alt="kottbullar"></center>
       </a>
    <br>
<h2>Veganska Köttbullar</h2>
    <br>
<p>För 4 personer</p>    
<h3>Ingredienser:</h3>
    <p>3 dl rött råris</p>
    <p>1 förp. à 380 g kokta kikärter</p>
    <p>2 msk dijonsenap</p>
    <p>1/2 tsk salt</p>
    <p>1/2 tsk malen kryddpeppar</p>
    <p>2 krm malen nejlika</p>
<p> 2 krm malen svartpeppar</p>
    <br>
<h3> Gör såhär:</h3>
   <p>Koka riset enligt anvisningen på förpackningen och låt kallna.</p>
<p>Skölj kikärtorna rinna och låt rinna av. Mixa alla ingredienser till en smet och forma till bullar. Låt bullarna ligga i kylen ca 30 minuter så det stelnar till.</p>
    <p>Stek dem i oljan i en stekpanna och servera.</p>
    <br>
    <br>
    <br>
    
    <title>Comment</title>

    <?php
        // SQL query för att hämta alla kommentarer för en specifik article
        $sql_get_comments = "SELECT User, Comment, Created_at FROM comments WHERE Article = ? ;";
        if($stmt_comment = mysqli_prepare($link, $sql_get_comments)){          
            mysqli_stmt_bind_param($stmt_comment, "s", $param_arctile);
            
            // Bestämmer vilken artikel/recept
            $param_arctile = $_SERVER['REQUEST_URI'];
           
            mysqli_stmt_execute($stmt_comment);
           
            /* bind result variables */
            mysqli_stmt_bind_result($stmt_comment, $name, $comment_result, $date);
            /* fetch values */
            while (mysqli_stmt_fetch($stmt_comment)) {
                printf ("<form action='%s' metod='get'>User: <input type='text' name='user'  value='%s' readonly><br>%s<br>Comment <input type='text' name='Comment' value='%s' readonly><br><input type='submit' value='Delete'></form>", htmlspecialchars($_SERVER["PHP_SELF"]),$name, $date,$comment_result);
            }
        }
        // Close connection
        mysqli_close($link);
    ?>
    <div class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($comment_err)) ? 'has-error' : ''; ?>">
                <label>Comment:</label>
                <input type="text" name="new_comment"class="form-control" value="<?php echo $comment; ?>">
            </div>  
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
         
        </form>
    </div>    
    
    
</body>
</html>