<?php
require "includes/pre-html.php";
require "includes/config.inc.php";
$page_title = "415 Recipes";

//check if user logged in:
if (!is_logged_in()){
  header("Location:/login.php");
  exit();
}

//open database connection
require(MYSQL);

//get current user
$current_user_id = $_SESSION["user_id"];
$current_user_name = $_SESSION["first_name"]." ".$_SESSION["last_name"];

//all is well, fetch the recipes:
$errors = array();
$recipes = array();
$q = "SELECT recipe_id, name, posted_on, img, description FROM recipes WHERE user_id = '$current_user_id'";
$r = mysqli_query($dbc,$q) or trigger_error("error accessing database 15");
if(mysqli_num_rows($r) > 0){
  while($row = mysqli_fetch_assoc($r)){
    $new_array = array("recipe_id" => $row["recipe_id"], "recipe_name" => $row["name"], "posted_on" => $row["posted_on"], "description" => $row["description"], "img" => $row["img"]);
    array_push($recipes, $new_array);
  }
  mysqli_free_result($r);
}
else{
  //no recipes found
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
      
      <?php
      if(isset($_SESSION["notice"]) && $_SESSION['notice']['type'] == "success"){
        echo "
        <br> 
        <div class = \"row justify-content-center align-items-center\">
        <div class=\"alert alert-success\" role=\"alert\">
          A simple danger alert—check it out!
        </div>
      </div>
        ";
      }
      elseif(isset($_SESSION["notice"]) && $_SESSION["notice"]["type"] == "failure"){
      echo "
        <br> 
        <div class = \"row justify-content-center align-items-center\">
        <div class=\"alert alert-danger\" role=\"alert\">
          A simple danger alert—check it out!
        </div>
      </div>
        ";
      }
      ?>
       
  <div class = "row justify-content-center align-items-center search-row">
    
      <form class="form-inline" action="search.php" method="get" id="search_form">
      <input class="form-control form-control-lg" type="search" placeholder="Search" aria-label="Search" name="search_text">
      <button class="btn btn-outline-warning btn-lg search-button" type="submit">Search</button>
    </form>
      </div>
    <hr>
        
          <div class = "row justify-content-center align-items-center">
          <h1 class="display-4">My Recipes</h1>
          </div>
          
          <?php
            $recipes_counter=0;
            $beginning_of_raw = true;
            
            echo "<div class = \"row bottom-distance-5 justify-content-center\">";
            
            foreach($recipes as $recipe){
              $output="";
              if($recipe["img"] != ""){
                $img = cl_image_tag($recipe["img"], array("class" => "img-fluid mx-auto d-block card-img-top", "crop" => "crop", "gravity"=>"custom"));
              }
              else{
                $img = cl_image_tag(NO_IMAGE_RECIPE, array("class" => "img-fluid mx-auto d-block card-img-top", "crop" => "crop", "gravity"=>"custom"));
              }
  
              if($recipes_counter%3 == 0){
                $output .= "</div>";
                $output .= "<div class = \"row bottom-distance-5 justify-content-center\">";
              }
              $output .=
              "
              
              <div class=\"card card-spacing\" style=\"width: 18rem;\">
                $img
                  <div class=\"card-body d-flex flex-column\">
                    <a href = '/view-recipe.php?id=".$recipe['recipe_id']."' class='linked-text'><h5 class=\"card-title\">".$recipe['recipe_name']."</h5></a>
                    <p class=\"posted\">".$recipe["posted_on"]."</p>
                    <p class=\"card-text\">".$recipe["description"]."</p>
                    <a href=\"/edit-recipe.php?id=".$recipe["recipe_id"]."\" class=\"btn btn-primary mt-auto\">edit</a>
                  </div>
              </div>
              
              ";
            
            $recipes_counter++;
            echo ($output);
            }
            echo "</div>";
          ?>
            
            
            
            
            
            
            
            
            
            
            
            
            
            
          
          
          
          
          
          
          
          
          
          
         
          
          
          
          
          
          
          <div class="row bg-black">
              <div class="col-sm white-text"><br><br>© 415 Recipes 2018. All rights reserved</div>
              <div class="col-sm white-text"></div>
          </div>
</div>
</body>
</html>