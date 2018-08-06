<form id="post_comment_form" name="post_comment_form" action="post_comment.php" method="post">
        <div class="form-group bottom-distance-5">
            <label for="CommentBody" class="modal-text">Comment</label>
            <textarea class="form-control" id="CommentBody" name="CommentBody" rows="3"></textarea><br>
            <input type="hidden" id="commented_recipe_id" name ="commented_recipe_id" value = "<?php echo $recipe_id?>"></input>
            <input type = "submit" class="btn btn-large btn-outline-success float-right" value="Post" id="post_comment_button"></input>
        </div>
    </form>