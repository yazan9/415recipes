<?php
require "includes/pre-html.php";
require "includes/config.inc.php";
$errors = null;
?>
<?php
if (isset($_POST['CommentBody']) && $_POST['CommentBody'] != '' && isset($_SESSION['user_id']) && isset($_POST['commented_recipe_id'])){
    //all is well, perform validations
    //1. sanitize comment body and make sure it's not empty
    $commentBody = $_POST['CommentBody'];
    //1. validate commentBody
    if(trim(strlen($commentBody))>=1){
        //open database connection
        require('mysqli_connect.php');
        $commentBody = mysqli_real_escape_string($dbc, $commentBody);
    }
    else{
        //user bypassed JS validation
        array_push($errors,"Invalid recipe_name");
        exit();
    }
    
    //2. make sure that recipe id is numeric
    $recipe_id = $_POST['commented_recipe_id'];
    if(!is_numeric($recipe_id)){
        array_push($errors,"Invalid recipe_id");
        exit();
    }
    
    //3. get the id of the user
    $user_id = $_SESSION['user_id'];
    
    //build the query for the recipe
    $q = "INSERT INTO comments (user_id, recipe_id, parent_id, posted_on, body) VALUES ('$user_id', '$recipe_id', 0, now(), '$commentBody')";
    $r = mysqli_query($dbc,$q) or trigger_error(mysqli_error($dbc));
        
    if(!$r){
        //something went wrong
        array_push($errors,"DB query failed");
        exit();
    }
        
    //get the ID of the inserted comment
    $comment_id = mysqli_insert_id($dbc);
    
    //get the comment
    $q = "SELECT comments.*,users.first_name, users.last_name, users.avatar, users.user_id from comments, users where comments.comment_id = '$comment_id' and users.user_id = comments.user_id";
    $r = mysqli_query($dbc, $q) or trigger_error("error accessing database 21");
        
    //read the results into the results array
    if(mysqli_num_rows($r) > 0){
        $row = mysqli_fetch_assoc($r);
        $comment = array("user_id" => $row["user_id"], "body" => $row["body"], "posted_on" => $row["posted_on"], "first_name" => $row["first_name"], "last_name" => $row["last_name"], "img" => $row['avatar'], "user_id" => $row['user_id']);
    }
    else{
        $comment = NULL;
    }
    
    if($comment != NULL){
        $body = $comment['body'];
        $posted_on = $comment['posted_on'];
        $user_name = $comment['first_name']." ".$comment['last_name'];
        $img = $comment['img'];
        $user_id = $comment['user_id'];
        include "render_comment.php";
    }
}
else{
    echo "error";
}
?>