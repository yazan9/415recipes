//password, ConfirmPassword
$(function(){
    $('#change_password_form').submit(function(e){
        
        //set defaults
        $('#new_password').removeClass('is-invalid');
        $('#confirm_new_password').removeClass('is-invalid');
        $('#password_errors').hide();
        $('#password_errors').html("");

        
        //intercept submission:
        e.preventDefault();
        
        //start validation
        var flag = true;
        
        //validate password
        var pass = $('#new_password').val();
        if(pass.trim() == ""){
            $('#new_password').addClass('is-invalid');
            flag = false;
        }
        
        //validate password match
        var pass = $('#confirm_new_password').val();
        if(pass.trim() == "" || $('#new_password').val() != pass){
            $('#confirm_new_password').addClass('is-invalid');
            flag = false;
        }
        //if all is well, submit the form
        if(flag){

            //build the data
            var data = new Object();
            data.password = $('#new_password').val();
            data.confirm_password = $('#confirm_new_password').val();

            //build the option for the AJAX request
            var options = new Object();
            options.data = data;
            options.url = "perform-change-password.php";
            options.dataType = 'text';
            options.type = 'post';
            options.success = function(response){
                //code 200
                if(response == "ok"){
                    $('#password_modal_body').html("Your password has been changed successfully");
                }
                else if(response == "password is invalid"){
                    $('#password_errors').show();
                    $('#password_errors').html("Please choose another password that is at least 4 characters long");
                }
                else {
                    $('#password_errors').show();
                    $('#password_errors').html("Oops, something went wrong...");
                }
            };
            $.ajax(options);
            //return false;
        }
        else{
            //there are errors
            $('#password_errors').show();
            $('#password_errors').html("Please fix the following errors");
        }
        });
    //return false;
});