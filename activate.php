<?php
require "includes/pre-html.php";
require "includes/config.inc.php";
$page_title = "415 Recipes";
?>
<?php
//check that correct values were received
if(isset($_GET['email'], $_GET['x']) 
&& filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)){
    //correct values received
    
    //connect to the database:
    require(MYSQL);
    
    //build the query:
    $q = "UPDATE users SET active=NULL WHERE (email='"
    .mysqli_real_escape_string($dbc, $_GET['email'])
    ."' AND active='"
    .mysqli_real_escape_string($dbc, $_GET['x'])
    ."') LIMIT 1";
    
    //execute the query
    $r = mysqli_query($dbc,$q) or trigger_error("Error 003");
    
    //count the results
    if(mysqli_affected_rows($dbc) == 1){
        //success
        $flag = true;
    }
    else{
        //failure
        $flag = false;
    }
    
    //close the connection
    mysqli_close($dbc);
}
else{
    //bad inputs
    //header("Location:/");
    echo "shit";
}
?>
<!DOCTYPE html>
<html lang="en">
<?php
include "includes/header.php";
?>
<body>
<?php
include "includes/navbar.php";
include "signup-modal.php";
include "login-modal.php";
?>

<div class="container-fluid">
    <div class="row justify-content-center align-items-center bottom-distance-5">
    </div>
    
    <div class="row justify-content-center align-items-center bottom-distance-5">
        <?php
        if($flag == true){
         echo "<h1>Your account has been activated, you may now log in!</h1>";
        }
        else{
            echo "we are sorry, something were terribly wrong ...";
        }
         ?>
    </div>
    </div>
    </body>
    </html>
    