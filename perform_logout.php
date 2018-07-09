<?php
require('includes/pre-html.php');
require('includes/config.inc.php');
//if no session exists:
if(!isset($_SESSION['first_name'])){
    //redirect to root:
    header('Location:/');
}
else{ //session exists, perform log out
    $_SESSION = []; //destroy all variables
    session_destroy(); //destroy the session
    setcookie(session_name(),'',time()-3600); //destroy the cookie
    
    //then redirect to main page:
    header('Location:/');
}
?>