<?php
require "includes/pre-html.php";
?>
<?php
require('includes/config.inc.php');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //open database connection:
    require(MYSQL);
    
    //validate email address
    if(!empty($_POST['email'])){
        $email = mysqli_real_escape_string($dbc, $_POST['email']);
    }
    else{
        $email = false;
    }
    
    //validate password
    if(!empty($_POST['password'])){
        $password = trim($_POST['password']);
        $password = mysqli_real_escape_string($dbc, $password);
    }
    else{
        $password = false;
    }
    
    //if all is ok:
    if($email && $password){

        //build the query
        $q = "SELECT user_id, first_name, last_name, user_level, pass
        FROM users
        WHERE email = '$email'
        AND active IS NULL
        ";
        
        //run the query
        $r = mysqli_query($dbc,$q) or trigger_error("error 004");
        
        //if there is a match, read the result
        if(mysqli_num_rows($r) == 1){

            list($user_id, $first_name, $last_name, $user_level, $pass)=
            mysqli_fetch_array($r, MYSQLI_NUM);
            
            mysqli_free_result($r);
            
            //check the password:
            if(password_verify($password, $pass)){

                //store the info in the session
                $_SESSION['user_id'] = $user_id;
                $_SESSION['first_name'] = $first_name;
                $_SESSION['last_name'] = $last_name;
                $_SESSION['user_level'] = $user_level;
                
                //close the database connection
                mysqli_close($dbc);
                //header("Location:/");
                echo "success";
                exit();
            }else{
                
            }
        }else{
            
        }
    }
    else{
        //the user has messed with the form, do nothing:
    }
    
}
?>