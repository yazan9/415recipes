<!-- Modal -->
<div class="modal fade" id="PasswordModal" tabindex="-1" role="dialog" aria-labelledby="PasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="display-4">Change Password</h1>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="password_modal_body">
        
        
     <div class="alert alert-danger hidden" role="alert" id="password_errors"></div>
   
        
        <form action="perform-change-password.php" method="post" id="change_password_form" novalidate>
  <div class="form-group">
    <label for="new_password" class="modal-text">New Password</label>
    <input type="password" class="form-control form-control-lg" id="new_password" placeholder="Password">
    <div class="invalid-feedback">
        Please provide a valid password
    </div>
  </div>
  
   <div class="form-group">
    <label for="confirm_new_password" class="modal-text">Confirm New Password</label>
    <input type="password" class="form-control form-control-lg" id="confirm_new_password" placeholder="Confirm Password">
    <div class="invalid-feedback">
        Passwords do not match
    </div>
  </div>
  
  
  <input type="submit" class="btn btn-warning btn-lg" value = "Change" name="submit"></input>
</form>

        
        
      </div>
    </div>
  </div>
</div>