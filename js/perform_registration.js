//email, password, ConfirmPassword
$(function(){
    $('#registration_form').submit(function(e){
        
        //set defaults
        $('#email').removeClass('is-invalid');
        $('#password').removeClass('is-invalid');
        $('#ConfirmPassword').removeClass('is-invalid');
        $('#first_name').removeClass('is-invalid');
        $('#last_name').removeClass('is-invalid');
        $('#registration_errors').hide();
        $('#registration_errors').html("");

        
        //intercept submission:
        e.preventDefault();
        
        //start validation
        var flag = true;
        
        //validate email address:
        var isvalid = isValidEmailAddress($('#email').val());
        if(!isvalid){
            $('#email').addClass('is-invalid');
            flag = false;
        }
        
        //validate password
        var pass = $('#password').val();
        if(pass.trim() == ""){
            $('#password').addClass('is-invalid');
            flag = false;
        }
        
        //validate password match
        var pass = $('#ConfirmPassword').val();
        if(pass.trim() == "" || $('#password').val() != pass){
            $('#ConfirmPassword').addClass('is-invalid');
            flag = false;
        }
        
        //validate first name
        var first_name = $('#first_name').val();
        if(first_name.trim() == ""){
            $('#first_name').addClass('is-invalid');
            flag = false;
        }
        
        //validate last name
        var last_name = $('#last_name').val();
        if(last_name.trim() == ""){
            $('#last_name').addClass('is-invalid');
            flag = false;
        }
        
        //if all is well, submit the form
        if(flag){
            //build the data
            var data = new Object();
            data.email = $('#email').val();
            data.password = $('#password').val();
            data.confirm_password = $('#ConfirmPassword').val();
            data.first_name = $('#first_name').val();
            data.last_name = $('#last_name').val();

            //build the option for the AJAX request
            var options = new Object();
            options.data = data;
            options.url = "/perform-registration.php";
            options.dataType = 'text';
            options.type = 'post';
            options.success = function(response){
                //code 200
                if(response.slice(-6) == "S040ok"){
                    $('#signup_modal_body').html("An email has been sent to you with a confirmation code, please verify your email and enjoy our platform!")
                }
                else if(response == "email not available"){
                    $('#registration_errors').show();
                    $('#registration_errors').html("Email address already registered");
                }
                else if(response == "password is invalid"){
                    $('#registration_errors').show();
                    $('#registration_errors').html("Please choose another password that is at least 4 characters long");
                }
                else {
                    $('#registration_errors').show();
                    $('#registration_errors').html("Oops, something went wrong...");
                    //$('#registration_errors').html(response);
                }
            };
            $.ajax(options);
            //return false;
        }
        else{
            //there are errors
            $('#registration_errors').show();
            $('#registration_errors').html("Please fix the following errors");
        }
        });
    //return false;
});

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    // alert( pattern.test(emailAddress) );
    return pattern.test(emailAddress);
};