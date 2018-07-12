<?php
require "includes/pre-html.php";
require "includes/config.inc.php";
$page_title = "415 Recipes";
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
    
    <div class="row bg-black">
    <div class="col-sm">
        <div class="main-intro">
      <h1 class="display-1 white-text">Everyday<br>Recipes</h1><br>
      <h4 class="white-text">Enjoy our collection of healthy and delicious recipes and ideas. For everyday, and every occasion!</h4>
      <br>
      <a class="btn btn-outline-light btn-lg" href="/view-recipes.php" role="button"> See our delicious recipes</a>
      <br><br>
      </div>
    </div>
    <div class="col-sm">
      <img src="https://res.cloudinary.com/dzv1zwbj5/image/upload/v1527745216/Gourmet-food2.jpg" class="img-fluid" alt="yummy food"/>
    </div>
  </div>
  
  <div class = "row justify-content-center align-items-center search-row">
      <form class="form-inline" action="search.php" method="get" id="search_form">
      <input class="form-control form-control-lg" type="search" placeholder="Search" aria-label="Search" name="search_text">
      <button class="btn btn-outline-warning btn-lg search-button" type="submit">Search</button>
    </form>
      </div>
    <hr>
      <div class = "row justify-content-center align-items-center">
          <h1 class="display-4">Yummiest recipes</h1>
    </div>
    
    <?php
    //open the databse connection
    require(MYSQL);
    
    //import the recipes partial
    require("_display_recipes.php");
    ?>
    
    <?php
    //build the query to fetch the recipes:
    
    $errors = array();
    $recipes = array();
    $q = "SELECT recipes.recipe_id, recipes.name, recipes.posted_on, recipes.description, recipes.img, users.first_name, users.last_name, users.avatar, users.user_id  FROM recipes,users where recipes.user_id = users.user_id order by posted_on desc LIMIT 2";
    $r = mysqli_query($dbc,$q) or trigger_error("error accessing database 17");
    if(mysqli_num_rows($r) > 0){
        while($row = mysqli_fetch_assoc($r)){
            $new_array = array("recipe_id" => $row["recipe_id"], "recipe_name" => $row["name"], "posted_on" => $row["posted_on"], "description" => $row["description"], "img" => $row["img"], "first_name" => $row["first_name"], "last_name" => $row["last_name"], "avatar" => $row["avatar"], "user_id" => $row["user_id"]);
            array_push($recipes, $new_array);
        }
        mysqli_free_result($r);
    }
    else{
        //no recipes found
    }
    
    display_featured_recipes($recipes,28);
    ?>
          <hr>
          <div class = "row justify-content-center align-items-center">
          <h1 class="display-4">More Yummy Recipes</h1>
          </div>
          
    <?php
    //build the query to fetch the recipes:
    

    $errors = array();
    $recipes = array();
    $q = "SELECT recipes.recipe_id, recipes.name, recipes.posted_on, recipes.description, recipes.img, users.first_name, users.last_name, users.avatar, users.user_id  FROM recipes,users where recipes.user_id = users.user_id order by posted_on desc LIMIT 6";
    $r = mysqli_query($dbc,$q) or trigger_error("error accessing database 18");
    if(mysqli_num_rows($r) > 0){
        while($row = mysqli_fetch_assoc($r)){
            $new_array = array("recipe_id" => $row["recipe_id"], "recipe_name" => $row["name"], "img" => $row["img"], "posted_on" => $row["posted_on"], "description" => $row["description"], "first_name" => $row["first_name"], "last_name" => $row["last_name"], "avatar" => $row["avatar"], "user_id" => $row["user_id"]);
            array_push($recipes, $new_array);
        }
        mysqli_free_result($r);
    }
    else{
        //no recipes found
    }
    
    display_yummy_recipes($recipes,22);
    ?>
          

          <div class = "row justify-content-center align-items-center bottom-distance-5 stand-alone-row">
            <a class="btn btn-outline-warning btn-lg" href="/view-recipes.php" role="button"> Explore More Great Stuff</a>
          </div>
          
          
          <hr>
          <div class = "row justify-content-center align-items-center bottom-distance-5">
          <h1 class="display-4">Selected Article</h1>
          </div>
          
          <div class = "row bottom-distance-5">
          <div class="col-sm">
              <img src="https://res.cloudinary.com/dzv1zwbj5/image/upload/v1527830441/Article_Dish.jpg" class="img-fluid float-right" alt="yummy food"/>
          </div>
          <div class="col-sm">
                <a class="linked-text" href="#"><h2>6 Simple Make-Ahead Brunch Recipes To Help You Sail Through Sunday</h2></a>
                <br>
                <p class="description-text">Yes, you can still roll out of bed and into a cup of coffee and a 
                plate of eggs—but this way, you don’t even have to change out of your PJs</p>
                <br>
            <div><button type="button" class="btn btn-outline-warning btn-lg">Read More</button></div>
          </div>
          </div>
          
          
          
          
         <?php
         include "includes/footer.php"
         ?>
          
          
</div>
</body>
</html>