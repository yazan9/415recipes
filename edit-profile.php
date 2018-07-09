<?php
require "includes/pre-html.php";
require "includes/config.inc.php";
$page_title = "415 Recipes";
?>
<?php
//set user id
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}
else{//bad call
    header("Location:/");
    exit();
}

//open the database connection
require_once(MYSQL);

//get the user
$q = "SELECT user_id,first_name,last_name,registration_date,avatar from users where user_id =".$user_id;
$r = mysqli_query($dbc,$q) or trigger_error(mysqli_error($dbc));

//if there is a match, read the result
if(mysqli_num_rows($r) == 1){
    list($id, $first_name, $last_name, $registration_date, $avatar)=
    mysqli_fetch_array($r, MYSQLI_NUM);
    mysqli_free_result($r);
}
else{
    header("Location:/error_page.php");
    exit();
}

//process avatar image
if($avatar!=NULL){
    $avatar = cl_image_tag($avatar, array("transformation"=>array(
  array("width"=>150, "height"=>150, "gravity"=>"face", "radius"=>"max", "crop"=>"fill"),
  array("width"=>150, "crop"=>"fill")
  )));
}
else{
    $avatar = cl_image_tag("Placeholder", array("transformation"=>array(
  array("width"=>150, "height"=>150, "gravity"=>"face", "radius"=>"max", "crop"=>"fill"),
  array("width"=>150, "crop"=>"fill")
  )));
}
//mysqli_close($dbc);
?>
<?php
//a variable to determine whether an update was made and the result of it
$success = "undefined";
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //if the form is submitted:
    require_once(MYSQL);
    
    //trim all incoming data:
    $trimmed = array_map('trim', $_POST);
    
   //validate first name:
    if(strlen($trimmed['first_name'])>=1){
        $first_name = mysqli_real_escape_string($dbc, $trimmed['first_name']);
    }
    
    //validate last name:
    if(strlen($trimmed['last_name'])>=1){
        $last_name = mysqli_real_escape_string($dbc, $trimmed['last_name']);
    }
    
    //validate avatar
    if(isset($trimmed['avatar'])){
        $avatar = mysqli_real_escape_string($dbc, $trimmed['avatar']);
    }
    else{
        $avatar = null;
    }
    
    //build the query:
    $q = "UPDATE users SET first_name = '{$first_name}', last_name='{$last_name}', avatar = '{$avatar}'  WHERE user_id = {$user_id} LIMIT 1";
    
    //run the query:
    $r = mysqli_query($dbc,$q) or trigger_error(mysqli_error($dbc));
    
    //check if an update was made:
    if($r){
        $success = "updated";
        header("Location:/view-profile.php?success=updated");
        exit();
    }
    else{
        $success = "error";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<?php
include "includes/header.php";
?>
<body>
<?php
include "includes/navbar.php";
include "signup-modal.php";
include "login-modal.php";
include "password-modal.php";
?>
    <div class="container-fluid">
    <div class="row justify-content-center align-items-center bottom-distance-5">
    </div>
    
    <?php
    if($success == "error"){
        echo "
        <div class='row justify-content-center align-items-center'>
        <div class='alert alert-danger' role='alert'>
        Sorry, something went wrong :(
        </div>
        </div>
        ";
    }
    else{
        //display nothing
    }
    ?>
    
    <div class="row">
        <div class="col-2">
            <div class="image_container">
                <div id="updated_img"><?php echo $avatar;?></div>
                <a href="#" id="upload_widget_opener"><div class="full_image_click align-items-center"><center>Update</center></div></a>
            </div>
        </div>
        <div class="col-4">
  <form action="edit-profile.php" method="post" id="edit_profile_form">
  <div class="form-group bottom-distance-5">
    <label for="first_name" class="modal-text">First Name</label>
    <input class="form-control form-control-lg" id="edit_first_name" name="first_name" value=<?php echo "\"".$first_name."\"" ?> >
  </div>

  <div class="form-group bottom-distance-5">
    <label for="last_name" class="modal-text">Last Name</label>
    <input class="form-control form-control-lg" id="edit_last_name" name="last_name"; value=<?php echo "\"".$last_name."\"" ?> >
  </div>
  
  <input type="submit" class="btn btn-large btn-outline-success" value="Done" name="submit"></input>
  <button class="btn btn-large btn-outline-dark" name="submit">Cancel</button>
  <strong>
  <?php echo "<a data-toggle=\"modal\" data-target=\"#PasswordModal\" href='#' class='linked-text float-right'>Change Password</a>"; ?>
  </strong>
  
  </form>
  
  
  </div>
    </div>

   
            <div class="row bg-black fixed-bottom">
              <div class="col-sm white-text"><br><br>© 415 Recipes 2018. All rights reserved</div>
              <div class="col-sm white-text"></div>
            </div>    
    
</div>

<script src="https://widget.cloudinary.com/global/all.js?v=1" type="text/javascript"></script>  

<script type="text/javascript">  

//on file upload success
$(document).on('cloudinarywidgetfileuploadsuccess', function(e, data) {
    //append a hidden value to the form
    var form = $("#edit_profile_form");
    form.append("<input type='hidden' name='avatar' value='"+data.public_id+"'/>");
    
    //update the image seen by the user
    var img = $("#updated_img");
    $.ajax({url: "_deliver_avatar_image.php?img=" + data.public_id, success: function(result){
        img.html(result);
    }});
});

  //event for the widget
  document.getElementById("upload_widget_opener").addEventListener("click", function() {
    cloudinary.openUploadWidget({ cloud_name: 'dzv1zwbj5', upload_preset: 'z9mycu78'}, 
      function(error, result) { console.log(error, result) });
  }, false);
  
</script>
</body>
</html>