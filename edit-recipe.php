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
//check if user logged in:
if (!is_logged_in()){
  header("Location:/login.php");
  exit();
}

//check if recipe belongs to this user:
//open database connection
require(MYSQL);

//perform the check
$current_user_id = $_SESSION['user_id'];
if(!recipe_belongs_to_user($recipe_id,$current_user_id,$dbc)){
    header("Location:/");
    exit();
}

//set some arrays for the dropdowns
$time_units = array("Seconds", "Minutes", "Hours", "Days");

//all is well, fetch the recipes:
$errors = array();
$q = "SELECT * FROM recipes WHERE recipe_id = '$recipe_id'";
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
  $img = $row["img"];
  
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

//construct the image:
if($img == ""){
  $img = cl_image_tag(NO_IMAGE_RECIPE);
}
else{
  $img = cl_image_tag($img);
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
<script src="/js/edit_recipe.js?v=6"></script>
    <div class="container-fluid">
    <div class="row justify-content-center align-items-center bottom-distance-5">
    </div>
    
    <div class="row justify-content-center align-items-center">
      <div class="hidden alert alert-danger" id="add_recipe_errors_div"><strong>Please fix the following errors before proceeding</strong></div>
    </div>
    
    <div class="row justify-content-center bottom-distance-5">
        <h1 class="display-4">Edit your Recipe</h1>
    </div>
    
    <div class="row justify-content-center bottom-distance-5">
        <div class="image_container">
        <div id="updated_img"><?php echo $img;?></div>
        <a href="#" id="upload_widget_opener"><div class="full_image_click align-items-center"><center>Update</center></div></a>
        </div>
    </div>
    
    <div class="row bottom-distance-5 justify-content-center">
    <div class="col-4">
    <form action="perform-edit-recipe.php?recipe_id=<?php echo $recipe_id?>" method="post" id="edit_recipe_form">
  <div class="form-group bottom-distance-5">
    <label for="RecipeName" class="modal-text">Name Your Recipe*</label>
    <input class="form-control form-control-lg" id="RecipeName" name="RecipeName" placeholder="Yummy thing ..." value="<?php echo $name?>">
     <div class="invalid-feedback">
        Please provide a name for your recipe
    </div>
  </div>
  
  
  <div class="form-group bottom-distance-5">
    <label for="RecipeDescription" class="modal-text">Describe Your Recipe</label>
    <textarea class="form-control" id="RecipeDescription" name="RecipeDescription" rows="3"><?php echo $description?></textarea>
  </div>
  
  
  <div class="form-row bottom-distance-5">
    <div class="form-group col-md-8">
      <label for="CookTime" class="modal-text">Cook Time</label>
          <input class="form-control form-control-lg" id="CookTime" name="CookTime" placeholder="Cook Time" type="number" value = <?php echo $cook_time ?>>
    </div>
    <div class="form-group col-md-4">
      <label for="CookTimeUnit" class="modal-text">In</label>
      <select id="CookTimeUnit" name="CookTimeUnit" class="form-control form-control-lg">
        <?php
        echo "<option value="."'0'".($cook_unit == null ? " selected" : "").">"."Choose..."."</option>";
        foreach($time_units as $time_unit){
          echo "<option value="."'".$time_unit."'".($cook_unit == $time_unit? "selected" : "").">".$time_unit."</option>";
        }
        ?>
      </select>
    </div>
  </div>
  
  <div class="form-row bottom-distance-5">
    <div class="form-group col-md-8">
      <label for="PrepTime" class="modal-text">Prep Time</label>
                <input class="form-control form-control-lg" id="PrepTime" name="PrepTime" placeholder="Prep Time" type="number" value = <?php echo $prep_time ?>>
    </div>
    <div class="form-group col-md-4">
      <label for="PrepTimeUnit" class="modal-text">In</label>
      <select id="PrepTimeUnit" name="PrepTimeUnit" class="form-control form-control-lg">
        <?php
        echo "<option value="."'0'".($prep_unit == null ? " selected" : "").">"."Choose..."."</option>";
        foreach($time_units as $time_unit){
          echo "<option value="."'".$time_unit."'".($prep_unit == $time_unit? "selected" : "").">".$time_unit."</option>";
        }
        ?>
      </select>
    </div>
  </div>
  
  <div class="form-group bottom-distance-5">
    <label for="Serves" class="modal-text">Serves</label>
    <select id="Serves" name = "Serves" class="form-control form-control-lg">
      <?php
      echo "<option value=0".($serves == 0? " selected":"").">"."Choose..."."</option>";
      for($i = 1; $i<=7; $i++){
        echo "<option value=\"$i\"".($serves == $i? " selected":"").">".$i."</option>";
      }
      echo "<option value=8".($serves == 8? " selected":"").">"."8+"."</option>";
      ?>
      </select>
  </div>
  
  <hr>
  <div class="row justify-content-center bottom-distance-5">
        <h1 class="display-4">Ingredients</h1>
  </div>
    
  <div class="form-group bottom-distance-5" id="recipe_ingredients">
    <?php
    $ingredient_counter = 1;
    foreach($ingredients as $ingredient){
      $new_ingredient = "<div class=\"form-row bottom-distance-5\" id=\"new_ingredient_div_$ingredient_counter\">";
      $new_ingredient.= "<div class=\"form-group col-md-11\">";
      $new_ingredient.= "<label for=\"Ingredient\" class=\"modal-text ingredients_input\">Ingredient</label>";
      $new_ingredient.= "<input class=\"form-control form-control-lg\" id=\"new_ingredient_" . $ingredient_counter . "\" name=\"new_ingredient_" . $ingredient_counter . "\" placeholder=\"What is it?\" type=\"text\" value=\"".$ingredient."\"/>";
      $new_ingredient.= "</div>"; //end of column
        
      $new_ingredient.= "<div class=\"form-group col-md-1\">";
      $new_ingredient.= "<button type=\"button\" class=\"btn btn-large btn-outline-danger remove_button\" onclick=\"RemoveIngredient($ingredient_counter);\">x</button>";
      $new_ingredient.= "</div>"; //end of column
  
      $new_ingredient.= "</div>"; //end of row
      echo $new_ingredient;
      
      $ingredient_counter++;
    }
    
    ?>
  </div>
  
  <div class="form-group bottom-distance-5 justify-content-center">
    <button id="add_ingredient_button" type="button" class="btn btn-large btn-outline-warning">Add Ingredient</button>
  </div>
  
  <hr>
  <div class="row justify-content-center bottom-distance-5">
        <h1 class="display-4">Steps</h1>
    </div>
    
  <div class="form-group bottom-distance-5" id="recipe_steps">
    <?php
    $step_counter = 1;
    foreach($steps as $step){
      //add input for the step
      $new_step = "<div class=\"form-row bottom-distance-5\" id=\"new_step_div_$step_counter\">";
      $new_step .= "<div class=\"form-group col-md-11\">";
      $new_step .= "<label for=\"new_step_".$step_counter."\" class=\"modal-text steps_input\">Step "."</label><textarea class=\"form-control\" id=\"new_step_".$step_counter."\" name=\"new_step_".$step_counter."\" rows=\"3\">".$step."</textarea>";
      $new_step .= "</div>"; //end of column
      
      $new_step .= "<div class=\"form-group col-md-1\">";
      $new_step .= "<button type=\"button\" class=\"btn btn-large btn-outline-danger remove_button\" onclick=\"RemoveStep($step_counter);\">x</button>";
      $new_step .= "</div>"; //end of column
      
      $new_step .= "</div>"; //end of row
      echo $new_step;    
      
      $step_counter++;
    }
    ?>
  </div>
  
  <div class="form-group bottom-distance-5 justify-content-center">
    <button id="add_step_button" type="button" class="btn btn-large btn-outline-warning">Add Step</button>
  </div>
  
  <hr>
  <div class="row justify-content-center bottom-distance-5">
        <h1 class="display-4">Notes</h1>
    </div>
    
  <div class="form-group bottom-distance-5" id="recipe_notes">
    <?php
    $note_counter = 1;
    foreach($notes as $note){
      //add input for the step
      $new_note = "<div class=\"form-row bottom-distance-5\" id=\"new_note_div_$note_counter\">";
      
      $new_note .= "<div class=\"form-group col-md-11\">";
      $new_note .= "<label for=\"new_note_".$note_counter."\" class=\"modal-text notes_input\">Note "."</label><textarea class=\"form-control\" id=\"new_note_".$note_counter."\" name=\"new_note_".$note_counter."\" rows=\"3\">".$note."</textarea>";
      $new_note .= "</div>"; //end of column
      
      $new_note .= "<div class=\"form-group col-md-1\">";
      $new_note .= "<button type=\"button\" class=\"btn btn-large btn-outline-danger remove_button\" onclick=\"RemoveNote($note_counter);\">x</button>";
      $new_note .= "</div>"; //end of column
      
      $new_note .= "</div>";//end of row
  
      echo $new_note;    
      
      $note_counter++;
    }
    ?>  
  </div>
  
  <div class="form-group bottom-distance-5 justify-content-center">
    <button id="add_note_button" type="button" class="btn btn-large btn-outline-warning">Add Note</button>
  </div>
  <hr>
  <div class="form-group bottom-distance-5 justify-content-center">
    <button id="add_recipe_button" type="submit" class="btn btn-large btn-outline-success">Update Recipe</button>
    <a href="/perform-delete-recipe.php?id=<?php echo $recipe_id?>" id="delete_recipe_button"  class="btn btn-large btn-outline-danger">Delete Recipe</a>
  </div>
  
</form>
    </div>   

         
    </div>
    
            <div class="row bg-black">
              <div class="col-sm white-text"><br><br>© 415 Recipes 2018. All rights reserved</div>
              <div class="col-sm white-text"></div>
            </div>    
</div>
<script>
function RemoveIngredient(t) {
  var new_ingredient_div = "#new_ingredient_div_" + t;
  $(new_ingredient_div).remove();
};

function RemoveStep(t) {
  var new_step_div = "#new_step_div_" + t;
  $(new_step_div).remove();
};

function RemoveNote(t) {
  var new_note_div = "#new_note_div_" + t;
  $(new_note_div).remove();
};
</script>

<script src="//widget.cloudinary.com/global/all.js" type="text/javascript"></script>  

<script type="text/javascript">  

//on file upload success
$(document).on('cloudinarywidgetfileuploadsuccess', function(e, data) {
    //append a hidden value to the form
    var form = $("#edit_recipe_form");
    form.append("<input type='hidden' name='img' value='"+data.public_id+"'/>");
    
    //update the image seen by the user
    var img = $("#updated_img");
    img.html("<img src='" + data.url + "'>");
});

  //event for the widget
  document.getElementById("upload_widget_opener").addEventListener("click", function() {
    cloudinary.openUploadWidget({ cloud_name: 'dzv1zwbj5', upload_preset: 'z9mycu78', cropping: 'server', multiple: false, cropping_aspect_ratio: 1.0}, 
      function(error, result) { console.log(error, result) });
  }, false);
  
</script>

</body>
</html>