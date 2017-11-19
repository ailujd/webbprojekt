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
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Comment</title>
</head>
<body>
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