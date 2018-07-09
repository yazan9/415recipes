<?php
//if a form is being submitted:
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    //open database connection
    require('mysqli_connect.php');
    
    //trim all incoming data:
    $trimmed = array_map('trim', $_POST);
    
    //assume invalid values
    $first_name = $last_name = $email = $password = FALSE;
    
    //validate first name:
    if(strlen($trimmed['first_name'])>=1){
        $first_name = mysqli_real_escape_string($dbc, $trimmed['first_name']);
    }
    else{
        echo "Invalid first name";
        exit();
    }
    
    //validate last name:
    if(strlen($trimmed['last_name'])>=1){
        $last_name = mysqli_real_escape_string($dbc, $trimmed['last_name']);
    }
    else{
        echo "invalid last name";
        exit();
    }
    
    //validate email:
    if(filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL)){
        $email = mysqli_real_escape_string($dbc, $trimmed['email']);
    }
    else{
        //something went wrong:
        echo "invalid email";
        exit();
    }
    
    //validate password:
    if(strlen($trimmed['password'])>=4){
        if($trimmed['password'] == $trimmed['confirm_password']){
            $password = password_hash($trimmed['password'], PASSWORD_DEFAULT);
        }
        else{
            //the two passwords do not match
            echo "two passwords do not match";
            exit();
        }
    }
    else{
        //password in invalid
        echo "password is invalid";
        exit();
    }
    
    //if everything is ok:
    if($first_name && $last_name && $email && $password){
        $q = "SELECT user_id FROM users WHERE email='$email'";
        $r = mysqli_query($dbc,$q) or trigger_error ("Error Connecting to Database, code: 001");
        
        //if the email is available:
        if(mysqli_num_rows($r) == 0){
            //create an activation code
            $activation_code = md5(uniqid(rand(),true));
            
            //add the user to the database:
            $q = "INSERT INTO users(email,pass,first_name,last_name,active,registration_date) VALUES('$email', '$password', '$first_name', '$last_name', '$activation_code', NOW())";
            
            $r = mysqli_query($dbc, $q) or trigger_error(mysqli_error($dbc));
            
            //if quesry successful
            if(mysqli_affected_rows($dbc) == 1){
                //send an email with activation code:
                include "send_email.php";
                send_activation_email($email, $activation_code);
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
            //email not available:
            echo "email not available";
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