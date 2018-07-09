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
       
  <div class = "row justify-content-center align-items-center search-row">
      <form class="form-inline" action="search.php" method="get" id="search_form">
      <input class="form-control form-control-lg" type="search" placeholder="Search" aria-label="Search" name="search_text">
      <button class="btn btn-outline-warning btn-lg search-button" type="submit">Search</button>
    </form>
      </div>
    <hr>
        
          <div class = "row justify-content-center align-items-center">
          <h1 class="display-4">Yummy Recipes</h1>
          </div>
          
<?php
    //open the databse connection
    require(MYSQL);
    
    //import the recipes partial
    require("_display_recipes.php");
?>
<?php
    //prepare for pagination:
    //1. Set the display:
    $display = 18;
    
    //2. Calculate the pages:
    if(isset($_GET["p"]) && is_numeric($_GET["p"])){ //beginning of p if
        //p already passed
        $pages = $_GET["p"];
    }
    else{
        //calculate p
        //start by counting the results
        $q = "SELECT COUNT(recipe_id) FROM recipes ORDER BY posted_on DESC";
            
        //run the query
        $r = mysqli_query($dbc, $q) or trigger_error("error accessing database 18");
            
        //get the actual number of rows returned
        $row = mysqli_fetch_array($r, MYSQLI_NUM);
        $records = $row["0"];
        $total_records = $records;
            
        //calculate the number of pages
        if($records > $display){
            //more than 1 page needed
            $pages = ceil($records/$display);
            
        }
        else{
            //only 1 page is needed
            $pages = 1;
        }
    }//end of p IF
    
    //3.calculate where to start reading results
    if(isset($_GET['s']) && is_numeric($_GET['s'])){
        //s is supplied
        $start = $_GET['s'];
    }
    else{
        $start = 0;
    }
    //////////////////end setting pagination variables /////////////////////
    
    //build the query to fetch the recipes:
    $errors = array();
    $recipes = array();
    $q = "SELECT recipes.recipe_id, recipes.name, recipes.posted_on, recipes.description, recipes.img, users.first_name, users.last_name, users.avatar, users.user_id  FROM recipes,users where recipes.user_id = users.user_id order by posted_on desc LIMIT $start, $display";
    $r = mysqli_query($dbc,$q) or trigger_error("error accessing database 19");
    if(mysqli_num_rows($r) > 0){
        while($row = mysqli_fetch_assoc($r)){
            $new_array = array("recipe_id" => $row["recipe_id"], "recipe_name" => $row["name"], "img" => $row["img"], "posted_on" => $row["posted_on"], "description" => $row["description"], "first_name" => $row["first_name"], "last_name" => $row["last_name"], "user_id" => $row["user_id"], "avatar" => $row["avatar"]);
            array_push($recipes, $new_array);
        }
        mysqli_free_result($r);
    }
    else{
        //no recipes found
    }
    
    display_yummy_recipes($recipes,22);
    ?>
    
    <?php
    //print pagination controls:
        //make the links to other pages, if necessary
        if($pages>1){
            echo "<div class = \"row bottom-distance-5 justify-content-center\">";
            
            //determine current page
            $current_page=($start/$display) + 1;
            
            //print pagination container
            echo "
            <nav aria-label=\"Page navigation example\">
            <ul class=\"pagination\">
            ";
            
            //if this is not the first page, make a link to previous:
            if($current_page != 1){
                
                echo "<li class=\"page-item\">";
                echo "
                <a class=\"page-link\" href = \"view-recipes.php?s=".($start-$display)."&p=".$pages."\">Previous</a>
                ";
                echo "</li>";
            }
            
            //print numbered pages
            for($i=1;$i<=$pages;$i++){
                if($i!=$current_page){
                    echo "<li class=\"page-item\">";
                    echo "<a class=\"page-link\" href=\"view-recipes.php?s=".($display*($i-1))."&p=".$pages."\">".$i."</a>";
                    echo "</li>";
                }
                else{
                    echo "<li class=\"page-item active\">";
                    echo "<span class=\"page-link\">".$i."</span>";
                    echo "</li>";
                }
            }//end of for loop
            
            //if not the last page, print next:
            if($current_page != $pages){
                echo "<li class=\"page-item\">";
                echo "
                <a class=\"page-link\" href = \"view-recipes.php?s=".($start+$display)."&p=".$pages."\">Next</a>
                ";
                echo "</li>";
            }
            
            //close pagination container
            echo "</ul></nav>";
            echo "</div>"; //end of row
        }//end of if pages > 1
    ?>
    
    
    
    
    
          
          
          
        <?php
         include "includes/footer.php"
        ?>
          
          
</div>
</body>
</html>