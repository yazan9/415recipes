<script src="/js/comments.js?v=2"></script>

<div class="comments-container">
<div class="row justify-content-center align-items-center">
    <div class="col-12">
        <?php
        if(is_logged_in()){
            include "_render_comment_form.php";
        }
        else{
            echo "Please <a class=\"\" data-toggle=\"modal\" data-target=\"#loginModal\" href=\"#\">Login</a> to post a comment<br><br>";        
        }
        ?>
    </div>
</div>

<div id="new_comment">
    
</div>

<?php
//pull the comments
$comments = array();
//build the query
mysqli_free_result($r);

$q = "SELECT comments.*,users.first_name, users.last_name, users.avatar, users.user_id from comments, users where comments.recipe_id = '$recipe_id' and users.user_id = comments.user_id order by comments.posted_on desc";
$r = mysqli_query($dbc, $q) or trigger_error("error accessing database 21");
        
//read the results into the results array
if(mysqli_num_rows($r) > 0){
    while($row = mysqli_fetch_assoc($r)){
        $new_array = array("user_id" => $row["user_id"], "body" => $row["body"], "posted_on" => $row["posted_on"], "first_name" => $row["first_name"], "last_name" => $row["last_name"], "img" => $row['avatar'], "user_id" => $row['user_id']);
        array_push($comments, $new_array);
    }
}
else{
    $results = NULL;
}
?>

<?php
//for ($i=0;$i<5;$i++){
//    include "render_comment.php";
//}

foreach ($comments as $comment)
{
    $body = $comment['body'];
    $posted_on = $comment['posted_on'];
    $user_name = $comment['first_name']." ".$comment['last_name'];
    $img = $comment['img'];
    $user_id = $comment['user_id'];
    include "render_comment.php";
}
?>
</div>