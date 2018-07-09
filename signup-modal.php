<!-- Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="display-4">Register</h1>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="signup_modal_body">
        
<div class="alert alert-danger hidden" role="alert" id="registration_errors">
  
</div>
        <form action="perform-registration.php" method="post" id="registration_form" novalidate>
  <div class="form-group">
    <label for="email" class="modal-text">Email address</label>
    <input type="email" class="form-control form-control-lg" id="email" aria-describedby="emailHelp" placeholder="Enter email">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    <div class="invalid-feedback">
        Please provide a valid email
    </div>
  </div>
  <div class="form-group">
    <label for="password" class="modal-text">Password</label>
    <input type="password" class="form-control form-control-lg" id="password" placeholder="Password">
    <div class="invalid-feedback">
        Please provide a valid password
    </div>
  </div>
  
   <div class="form-group">
    <label for="ConfirmPassword" class="modal-text">Confirm Password</label>
    <input type="password" class="form-control form-control-lg" id="ConfirmPassword" placeholder="Confirm Password">
    <div class="invalid-feedback">
        Passwords do not match
    </div>
  </div>
  
  <div class="form-group">
    <label for="first_name" class="modal-text">First Name</label>
    <input type="text" class="form-control form-control-lg" id="first_name" aria-describedby="first_name_Help" placeholder="Enter Your First Name">
    <div class="invalid-feedback">
        Please provide a valid First Name
    </div>
  </div>
  
  <div class="form-group">
    <label for="last_name" class="modal-text">Last Name</label>
    <input type="text" class="form-control form-control-lg" id="last_name" aria-describedby="last_name_Help" placeholder="Enter Your Last Name">
    <div class="invalid-feedback">
        Please provide a valid Last Name
    </div>
  </div>
  
  
  
  <input type="submit" class="btn btn-warning btn-lg" value="Register"></input>
</form>
        
        
        
        
        
      </div>
    </div>
  </div>
</div>