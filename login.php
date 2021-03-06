<?php
require "includes/pre-html.php";
require "includes/config.inc.php";
$page_title = "415 Recipes";
?>
<!DOCTYPE html>
<html lang="en">
<?php
include "includes/header.php";
?>
<body>

<div class="container-fluid">

<div class="row justify-content-center align-items-center">
<div class="" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="display-4">Login</h1>
        
      </div>
      <div class="modal-body">
        
      <div class="alert alert-danger hidden" role="alert" id="login_errors">
  
      </div>
        
        
        <form action="perform-login.php" method="post" id="login_form" novalidate>
  <div class="form-group">
    <label for="LoginEmail" class="modal-text">Email address</label>
    <input type="email" class="form-control form-control-lg" id="LoginEmail" aria-describedby="emailHelp" placeholder="Enter email" required>
    <div class="invalid-feedback">
        Please provide a valid email
    </div>
  </div>
  <div class="form-group">
    <label for="LoginPassword" class="modal-text">Password</label>
    <input type="password" class="form-control form-control-lg" id="LoginPassword" placeholder="Password">
    <div class="invalid-feedback">
        Please provide a valid password
    </div>
  </div>
  
  
  <input type="submit" class="btn btn-warning btn-lg" value = "Login" name="submit"></input>
</form>
<br>Forgot your password? <a href="reset_password.php" class="linked-text">Click here</a>
      </div>
    </div>
  </div>
</div>

</div>
</div>
</body>
</html>