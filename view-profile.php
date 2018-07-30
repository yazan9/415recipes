<?php
require "includes/pre-html.php";
require "includes/config.inc.php";
$page_title = "415 Recipes";
?>
<?php
//set user id
if(isset($_GET['id'])){
    $user_id = $_GET['id'];
    if(is_owner_of_profile($user_id)){
        $is_owner = true;
    }
    else{
        $is_owner = false;
    }
}
elseif(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    $is_owner = true;
}
else{//bad call
    header("Location:/");
    exit();
}

//validate incoming string
if(!ctype_digit($user_id)){
    header("Location:/");
    exit();
}

//open the database connection and prepare the arguments
require(MYSQL);
$user_id = mysqli_real_escape_string($dbc, $user_id);

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
$avatar = display_avatar_big($avatar, $first_name." ".$last_name);

//fetch the recipes of this user
$errors = array();
$recipes = array();
$q = "SELECT recipe_id, name, description, first_name, last_name, posted_on, img, users.avatar, users.user_id from recipes, users where recipes.user_id = users.user_id AND users.user_id = '$user_id'";
$r = mysqli_query($dbc,$q) or trigger_error("error accessing database 20");
if(mysqli_num_rows($r) > 0){
  while($row = mysqli_fetch_assoc($r)){
    $new_array = array("recipe_id" => $row["recipe_id"], "recipe_name" => $row["name"], "img" => $row["img"], "posted_on" => $row["posted_on"], "description" => $row["description"], "first_name" => $row["first_name"], "last_name" => $row["last_name"], "user_id" => $row['user_id'], "avatar" => $row["avatar"]);
    array_push($recipes, $new_array);
  }
  mysqli_free_result($r);
  //import the recipes partial
}
else{
  //no recipes found
}

    require("_display_recipes.php");


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
?>

    <div class="container-fluid">
    <div class="row justify-content-center align-items-center bottom-distance-5">
        <?php 
        if(isset($_GET['success']) && $_GET['success'] == "updated"){
            echo "<div class='alert alert-success' role='alert'>
            Profile Updated
            </div>";
        } 
        ?>
    </div>
    
    <div class="row">
        <div class="col-2">
            <div><?php echo $avatar;?></div>
        </div>
        <div class="description-text">
            <h1 class="display-3">
                <?php
                echo ucwords($first_name." ".$last_name);
                ?>
            </h1>
            Member since <?php echo date_format(date_create($registration_date), "F j, Y");?>
            <?php if($is_owner) echo "<br><a href='/edit-profile.php' class='linked-text'>edit</a>"; ?>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center">
        <h1 class="display-4">Recipes</h1>
    </div>
    
    <?php display_yummy_recipes($recipes,22); ?>
    
            <div class="row bg-black">
              <div class="col-sm white-text"><br><br>© 415 Recipes 2018. All rights reserved</div>
              <div class="col-sm white-text"></div>
            </div>    
    
    
</div>
</body>
</html>