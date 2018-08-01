<?php
require "includes/pre-html.php";
require "includes/config.inc.php";
$page_title = "415 Recipes";

//check if an id is supplied
if(!isset($_GET['id']) || !is_integer((int)$_GET['id'])){
    header("Location: /");
    exit();
}
else{
    $recipe_id = $_GET['id'];
}
?>
<?php 
//set some arrays for the drop downs
$time_units = array("Seconds", "Minutes", "Hours", "Days");

//open database connection
require(MYSQL);

//all is well, fetch the recipe:
$errors = array();
$q = "SELECT recipes.*, users.first_name, users.last_name, users.avatar FROM recipes JOIN users USING (user_id ) WHERE recipe_id = '$recipe_id'";
$r = mysqli_query($dbc,$q) or trigger_error("error accessing database 10");
if(mysqli_num_rows($r) == 1){
  $row = mysqli_fetch_assoc($r);
  $name = $row["name"];
  $description = $row["description"];
  $cook_time = $row["cook_time"];
  $cook_unit = $row["cook_unit"];
  $prep_time = $row["prep_time"];
  $prep_unit = $row["prep_unit"];
  $serves = $row["serves"];
  $img = $row["img"];
  $user_id = $row["user_id"];
  $first_name = $row["first_name"];
  $last_name = $row["last_name"];
  $posted_on = $row["posted_on"];
  $img = cl_image_tag($row["img"], array("class" => "img-fluid mx-auto d-block"));
  $avatar = $row["avatar"];
  
  mysqli_free_result($r);
}
else{
  $errors = "could not find the recipe";
}

//all is well, fetch the ingredients:
$ingredients = array();
$q = "SELECT * FROM ingredients WHERE recipe_id = '$recipe_id'";
$r = mysqli_query($dbc,$q) or trigger_error("error accessing database 11");
if(mysqli_num_rows($r) > 0){
  while($row = mysqli_fetch_assoc($r)) {
    array_push($ingredients, $row["name"]);
  }
  mysqli_free_result($r);
}
else{
  $errors = "could not find ingredients";
}

//all is well, fetch the steps:
$steps = array();
$q = "SELECT * FROM steps WHERE recipe_id = '$recipe_id'";
$r = mysqli_query($dbc,$q) or trigger_error("error accessing database 11");
if(mysqli_num_rows($r) > 0){
  while($row = mysqli_fetch_assoc($r)) {
    array_push($steps, $row["description"]);
  }
  mysqli_free_result($r);
}
else{
  $errors = "could not find any steps";
}

//all is well, fetch the notes:
$notes = array();
$q = "SELECT * FROM notes WHERE recipe_id = '$recipe_id'";
$r = mysqli_query($dbc,$q) or trigger_error("error accessing database 12");
if(mysqli_num_rows($r) > 0){
  while($row = mysqli_fetch_assoc($r)) {
    array_push($notes, $row["description"]);
  }
  mysqli_free_result($r);
}
else{
  //do nothing, notes are optional
}

if(!empty($errors)){
  header("location:/error.php");
  exit();
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

?>
    <div class="container-fluid">
        
    <div class="row justify-content-center align-items-center bottom-distance-5">
      
    </div>
       
    <div class="row justify-content-center align-items-center bottom-distance-5">
        <h1 class="display-3"><?php echo $name?></h1>
    </div>
    
    <div class="row justify-content-center align-items-center bottom-distance-5">
        <div class="width-70">
        <p class="description-text">
          <?php echo $description?>
        </p>
        </div>
    </div>   
<div class="row justify-content-center align-items-center">
    <div class="">
      <?php 
        echo(display_avatar_small($avatar, $first_name." ".$last_name, $posted_on, $user_id)) ;
      ?>
        </div>
</div>


    
    <div class="row justify-content-center align-items-center bottom-distance-5">
        <div class="width-90">
        <?php echo $img?>  
        </div>
    </div>  
    
    
    
   <div class="row justify-content-center description-text text-center bottom-distance-5">
    <div class="col-3">
      <strong>Prep time:</strong> <?php echo $prep_time." ".$prep_unit;?>
    </div>
    <div class="col-3">
      <strong>Cook time:</strong> <?php echo $cook_time." ".$cook_unit;?>
    </div>
    <div class="col-3">
      <strong>Serves:</strong> <?php echo $serves;?>
    </div>
  </div>
       
       
<div class="row justify-content-center align-items-center bottom-distance-5">
        <h1 class="display-4">Ingredients</h1>
    </div>   

    <?php
    $ingredients_counter = 1;
    $display = "<div class=\"row justify-content-center align-items-center bottom-distance-5\">";
    foreach($ingredients as $ingredient){
      $display .= "<div class=\"width-70\">";
      $display .= "<p class=\"description-text\">$ingredient</p>";
      $display .= "</div>";
      
      $ingredients_counter++;
      }
      $display .= "</div>";
      echo $display;
    ?>
       
  <div class="row justify-content-center align-items-center bottom-distance-5">
    </div>     


<div class="row justify-content-center align-items-center bottom-distance-5">
        <h1 class="display-4">Instructions</h1>
    </div>   
    
    <?php
    $steps_counter = 1;
    foreach($steps as $step){
      $display = "<div class=\"row justify-content-center align-items-center bottom-distance-5\">";
      $display .= "<h1>Step ".$steps_counter."</h1>";
      $display .= "</div>";
      $display .= "<div class=\"row justify-content-center align-items-center bottom-distance-5\">";
      $display .= "<div class=\"width-70\">";
      $display .= "<p class=\"description-text\">$step</p>";
      $display .= "</div>";
      $display .= "</div>";
      
      $steps_counter++;
      
      echo $display;
    }
    ?>

<div class="row justify-content-center align-items-center bottom-distance-5">
        <h1 class="display-4">Notes</h1>
    </div> 
    
    <?php
    $notes_counter = 1;
    if(count($notes != 0)){
    foreach($notes as $note){
      $display = "<div class=\"row justify-content-center align-items-center bottom-distance-5\">";
      $display .= "<div class=\"width-70\">";
      $display .= "<p class=\"description-text\">$note</p>";
      $display .= "</div>";
      $display .= "</div>";
      
      echo $display;
    }
    }// end if
    else{
      
    }
    
    ?>
    
    <div class="row justify-content-center align-items-center bottom-distance-5">
    <?php if(recipe_belongs_to_user($recipe_id, $user_id, $dbc) == true)
        echo "<a href=\"/edit-recipe.php?id=".$recipe_id."\" class=\"btn btn-primary mt-auto\">edit</a>";
      ?>
      </div>
       
  <div class="row bg-black">
              <div class="col-sm white-text"><br><br>© 415 Recipes 2018. All rights reserved</div>
              <div class="col-sm white-text"></div>
          </div>
          
</div>
</body>
</html>