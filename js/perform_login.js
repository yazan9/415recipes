$(function(){
    $('#login_form').submit(function(e){
        //set defaults
        $('#LoginEmail').removeClass('is-invalid');
        $('#LoginPassword').removeClass('is-invalid');
        
        //intercept submission:
        e.preventDefault();
        
        //start validation
        var flag = true;
        
        //validate email address:
        var isvalid = isValidEmailAddress($('#LoginEmail').val());
        if(!isvalid){
            $('#LoginEmail').addClass('is-invalid');
            flag = false;
        }
        
        //validate password
        var pass = $('#LoginPassword').val();
        if(pass.trim() == ""){
            $('#LoginPassword').addClass('is-invalid');
            flag = false;
        }
        
        //if all is well, submit the form
        if(flag){
            //build the data
            var data = new Object();
            data.email = $('#LoginEmail').val();
            data.password = $('#LoginPassword').val();
        
            //build the options for the AJAX request
            var options = new Object();
            options.data = data;
            options.url = "perform-login.php";
            options.dataType = 'text';
            options.type = 'post';
            options.success = function(response){
                //do something;
                if(response == "success"){
                    window.location.href = "/";
                }
            };
            $.ajax(options);
            //return false;
        }
        });
    //return false;
});

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    // alert( pattern.test(emailAddress) );
    return pattern.test(emailAddress);
};