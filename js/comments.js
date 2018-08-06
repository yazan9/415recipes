$(function(){
 $('#post_comment_form').submit(function(e){
    //intercept submission:
    e.preventDefault();
    
    
    //validate first name
    var comment_body = $('#CommentBody').val();
    if(comment_body.trim() == ""){
      return;
    }
    
    //comment not empty, proceed to building AJAX request
    //build the data
            var data = new Object();
            data.CommentBody = comment_body;
            data.commented_recipe_id = $('#commented_recipe_id').val();
           
            //build the option for the AJAX request
            var options = new Object();
            options.data = data;
            options.url = "/post_comment.php";
            options.dataType = 'text';
            options.type = 'post';
            options.success = function(response){
                //code 200
                if(response != "error"){
                    $('#new_comment').prepend(response);
                    $('#new_comment').hide();
                    $("#new_comment").slideDown( "slow" );
                }
                
                else {
                    //an error occured
                }
            };
            $.ajax(options);
 });
});