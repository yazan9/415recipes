<?php
require "includes/pre-html.php";
require "includes/config.inc.php";
$page_title = "415 Recipes";
?>
<?php 
//check if user logged in:
if (!is_logged_in()){
  header("Location:/login-modal.php");
  exit();
}

//upload image placeholder:
$img = cl_image_tag("Placeholder");
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
<script src="/js/add_recipe.js?v=6"></script>
    <div class="container-fluid">
    <div class="row justify-content-center align-items-center bottom-distance-5">
    </div>
    
    <div class="row justify-content-center align-items-center">
      <div class="hidden alert alert-danger" id="add_recipe_errors_div"><strong>Please fix the following errors before proceeding</strong></div>
    </div>
    
    <div class="row justify-content-center bottom-distance-5">
        <h1 class="display-4">Create a new Recipe</h1>
    </div>
    
    <div class="row justify-content-center bottom-distance-5">
        <div class="image_container">
        <div id="updated_img"><?php echo $img;?></div>
        <a href="#" id="upload_widget_opener"><div class="full_image_click align-items-center"><center>Update</center></div></a>
        </div>
    </div>
    
    <div class="row bottom-distance-5 justify-content-center">
    <div class="col-4">

    <form action="perform-add-recipe.php" method="post" id="add_recipe_form">
  <div class="form-group bottom-distance-5">
    <label for="RecipeName" class="modal-text">Name Your Recipe*</label>
    <input class="form-control form-control-lg" id="RecipeName" name="RecipeName" placeholder="Yummy thing ...">
     <div class="invalid-feedback">
        Please provide a name for your recipe
    </div>
  </div>
  
  
  <div class="form-group bottom-distance-5">
    <label for="RecipeDescription" class="modal-text">Describe Your Recipe</label>
    <textarea class="form-control" id="RecipeDescription" name="RecipeDescription" rows="3"></textarea>
  </div>
  
  
  <div class="form-row bottom-distance-5">
    <div class="form-group col-md-8">
      <label for="CookTime" class="modal-text">Cook Time</label>
          <input class="form-control form-control-lg" id="CookTime" name="CookTime" placeholder="Cook Time" type="number">
    </div>
    <div class="form-group col-md-4">
      <label for="CookTimeUnit" class="modal-text">In</label>
      <select id="CookTimeUnit" name="CookTimeUnit" class="form-control form-control-lg">
        <option value="0" selected>Choose...</option>
        <option value="Seconds">Seconds</option>
        <option value="Minutes">Minutes</option>
        <option value="Hours">Hours</option>
        <option value="Days">Days</option>
      </select>
    </div>
  </div>
  
  <div class="form-row bottom-distance-5">
    <div class="form-group col-md-8">
      <label for="PrepTime" class="modal-text">Prep Time</label>
                <input class="form-control form-control-lg" id="PrepTime" name="PrepTime" placeholder="Prep Time" type="number">
    </div>
    <div class="form-group col-md-4">
      <label for="PrepTimeUnit" class="modal-text">In</label>
      <select id="PrepTimeUnit" name="PrepTimeUnit" class="form-control form-control-lg">
        <option value="0" selected>Choose...</option>
        <option value="Seconds">Seconds</option>
        <option value="Minutes">Minutes</option>
        <option value="Hours">Hours</option>
        <option value="Days">Days</option>
      </select>
    </div>
  </div>
  
  <div class="form-group bottom-distance-5">
    <label for="Serves" class="modal-text">Serves</label>
    <select id="Serves" name = "Serves" class="form-control form-control-lg">
        <option value="0" selected>Choose...</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8+</option>
      </select>
  </div>
  
  <hr>
  <div class="row justify-content-center bottom-distance-5">
        <h1 class="display-4">Ingredients</h1>
  </div>
    
  <div class="form-group bottom-distance-5" id="recipe_ingredients">
    
  </div>
  
  <div class="form-group bottom-distance-5 justify-content-center">
    <button id="add_ingredient_button" type="button" class="btn btn-large btn-outline-warning">Add Ingredient</button>
  </div>
  
  <hr>
  <div class="row justify-content-center bottom-distance-5">
        <h1 class="display-4">Steps</h1>
    </div>
    
    <div class="form-group bottom-distance-5" id="recipe_steps">
    
  </div>
  
  <div class="form-group bottom-distance-5 justify-content-center">
    <button id="add_step_button" type="button" class="btn btn-large btn-outline-warning">Add Step</button>
  </div>
  
  <hr>
  <div class="row justify-content-center bottom-distance-5">
        <h1 class="display-4">Notes</h1>
    </div>
    
    <div class="form-group bottom-distance-5" id="recipe_notes">
    
  </div>
  
  <div class="form-group bottom-distance-5 justify-content-center">
    <button id="add_note_button" type="button" class="btn btn-large btn-outline-warning">Add Note</button>
  </div>
  
  <div class="form-group bottom-distance-5 justify-content-center">
    <button id="add_recipe_button" type="submit" class="btn btn-large btn-outline-success">Add Recipe</button>
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
    var form = $("#add_recipe_form");
    form.append("<input type='hidden' name='img' value='"+data.public_id+"'/>");
    
    //update the image seen by the user
    var img = $("#updated_img");
    img.html("<img src='" + data.url + "'>");
});

  //event for the widget
  document.getElementById("upload_widget_opener").addEventListener("click", function() {
    cloudinary.openUploadWidget({ cloud_name: 'dzv1zwbj5', upload_preset: 'z9mycu78'}, 
      function(error, result) { console.log(error, result) });
  }, false);
  
</script>
</body>
</html>