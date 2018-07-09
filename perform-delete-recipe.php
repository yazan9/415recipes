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
  header("Location:/login-modal.php");
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

//all is well, delete the recipe
//delete existing recipe
$q = "DELETE FROM recipes WHERE recipe_id = $recipe_id LIMIT 1";
$r = mysqli_query($dbc, $q) or trigger_error("error accessing database 13");

//check that operation is successful
if(mysqli_affected_rows($dbc) == 1){
    $_SESSION['notice'] = array("type" => "success","text" => "Your recipe was deleted successfully");
    header("location:/my-recipes.php");
    exit();
}
else{
    $_SESSION['notice'] = array("type" => "success","text" => "We are sorry, an error occured while deleting your recipe");
    header("location:/edit-recipe.php?id=".$recipe_id);
    exit();
}
