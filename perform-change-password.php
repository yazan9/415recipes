<?php
require "includes/pre-html.php";
require "includes/config.inc.php";
$page_title = "415 Recipes";
?>
<?php
//check if user logged in:
if (!is_logged_in()){
  header("Location:/login-modal.php");
  exit();
}
else{
    $current_user_id = $_SESSION['user_id'];
}

//if a form is being submitted:
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    //open database connection
    require('mysqli_connect.php');
    
    //trim all incoming data:
    $trimmed = array_map('trim', $_POST);
    
    //assume invalid values
    $password = FALSE;
    
    //validate password:
    if(strlen($trimmed['password'])>=4){
        if($trimmed['password'] == $trimmed['confirm_password']){
            $password = password_hash($trimmed['password'], PASSWORD_DEFAULT);
        }
        else{
            //the two passwords do not match
            echo "the two passwords do not match";
            exit();
        }
    }
    else{
        //password in invalid
        echo "password is invalid";
        exit();
    }
    
    //if everything is ok:
    if($password){
        $q = "UPDATE users SET pass='$password' WHERE user_id='$current_user_id' LIMIT 1";
        $r = mysqli_query($dbc,$q) or trigger_error ("Error Connecting to Database, code: 001");
        
        //check if update is successful
        if(mysqli_affected_rows($dbc) == 1){
                echo "ok";
                exit();
            }
        else{
                //something went wrong
                echo "Error updating the database, code: 002";
                exit();
        }
    }
    else{
        //a databse test failed:
        echo "validation error";
        exit();
    }
    mysqli_close($dbc);
}//end of post conditional
?>