<div class="row justify-content-center align-items-center">
    <div class="col-2">
        <div class="float-right"><?php echo display_avatar_image_small($img,$user_name)?></div>
    </div>
    <div class="col-10">
        <?php
            $output = "<h5 class=\"mt-0\"><a class='linked-text' href='/view-profile.php?id=".$user_id."'>".ucwords($user_name)."</a></h5><p class=\"posted\">".$posted_on."</p>";
            echo $output;
        ?>
    </div>
</div>
<div class="row  justify-content-center align-items-center">
    <div class="col-2">
        
    </div>
    <div class="col-10">
        <?php
            $output = $body;
            echo $output;
            echo "<br>";
        ?>
        <div class="row reply justify-content-center align-items-center"></div>
    </div>
</div>
<br><br>