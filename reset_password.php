<?php
require "includes/pre-html.php";
require_once "includes/config.inc.php";
$page_title = "Reset Password";
$result = "";
//check if user logged in - do not reset password if this is the case
if (is_logged_in()){
  header("Location:/");
  exit();
}
else{ // user is not logged in
    //check if the form is being submitted:
    if($_SERVER['REQUEST_METHOD'] == "POST"){
    
        //open the database connection
        require(MYSQL);
        
        ///////////get user email//////////////
        $email = trim($_POST['reset_email']);
    
        //validate email:
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $email = mysqli_real_escape_string($dbc, $email);
        }
        else{
            //something went wrong:
            $result = "wrong format";
            exit();
        }
    
        //build and run the query
        $q = "SELECT user_id, email from users where email='$email'";
        $r = mysqli_query($dbc,$q);
    
        //if there is a match, read the result
        if(mysqli_num_rows($r) == 1){
            list($user_id, $email)=
            mysqli_fetch_array($r, MYSQLI_NUM);
            mysqli_free_result($r);
        }
        else{
            //something went wrong, email could not be found
            $result = "email not found";
            exit();
        }

        //if everything is ok, create a random password
        $password = substr(md5(uniqid(rand(),true)),3,15);

        //create a hashed version of the random password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        //build the query
        $q = "UPDATE users set pass='$hashed_password' WHERE email='$email' and user_id = '$user_id' LIMIT 1";

        //run the query
        $r = mysqli_query($dbc,$q) or trigger_mysqli_error($dbc);

        //if update successful
        if(mysqli_affected_rows($dbc) == 1){
    
            //send the new password in an email
            include "send_email.php";
            send_password_email($email, $password);
            $result = "success";
            //exit();
        }
    }
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
include "password-modal.php";
?>
<script src="js/password_reset.js?v=19"></script>
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center bottom-distance-5">
         </div>
         
         <?php
         if($result == "success"){
            echo "<div class=\"row justify-content-center align-items-center bottom-distance-5\">
            <div class=\"alert alert-success\">Your password has been reset successfuly, please check your email</div>
            </div>";
         }
         else if($result == "wrong_format" || $result == "email_not_found"){
            echo "<div class=\"row justify-content-center align-items-center bottom-distance-5\">
            <div class=\"alert alert-danger\">Your password could not be reset at this time, please try later</div>
            </div>"; 
         }
         ?>
         
         <div class="row justify-content-center">
             <div class="col-4">
             <h1 class="display-4">Reset Password</h1>

    <form action="reset_password.php" method="post" id="reset_password_form" name="reset_password_form" novalidate>
  <div class="form-group">
    <label for="reset_email" class="modal-text">Email address</label>
    <input type="email" class="form-control form-control-lg" id="reset_email" name="reset_email" aria-describedby="emailHelp" placeholder="Enter email">
    <div class="invalid-feedback">
        Please provide a valid email
    </div>
  </div>
  
  
  <input type="submit" class="btn btn-outline-warning btn-lg" value = "Reset Password" name="b1"></input>
</form>
</div>
</div>
    
    <div class="row bg-black fixed-bottom">
              <div class="col-sm white-text"><br><br>© 415 Recipes 2018. All rights reserved</div>
              <div class="col-sm white-text"></div>
            </div>    
    
</div>
</body>
</html>