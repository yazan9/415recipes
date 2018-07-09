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

<?php
//total records
$total_records = null;

//set an array for the results
$results = array();
//if a form is being submitted
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    //open database connection
    require(MYSQL);
    
    //set the number of results to display
    $display = 10;
    
    //check that there is a valid keyword for the search
    if(!isset($_GET["search_text"]) || trim($_GET["search_text"]) == ""){
        //no keyword supplied or keyword is empty
        $results = NULL;
    }
    else{
        //search keyword exists: sanitize input
        $search_text = strip_tags($_GET["search_text"]);
        $search_text = mysqli_real_escape_string($dbc,$search_text);
        
        //create pagination for the results
        if(isset($_GET["p"]) && is_numeric($_GET["p"])){ //beginning of p if
            //p already passed
            $pages = $_GET["p"];
        }
        else{
            //calculate p
            //start by counting the results
            $q = "SELECT COUNT(recipe_id) FROM recipes WHERE name like '%$search_text%' or description like '%$search_text%'";
            
            //run the query
            $r = mysqli_query($dbc, $q) or trigger_error("error accessing database 17");
            
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
        
        //calculate where to start reading results
        if(isset($_GET['s']) && is_numeric($_GET['s'])){
            //s is supplied
            $start = $_GET['s'];
        }
        else{
            $start = 0;
        }
        
        
        //build the query
        $q = "SELECT recipe_id, name, description, first_name, last_name, posted_on, img, users.avatar, users.user_id from recipes, users where recipes.user_id = users.user_id and (name like '%$search_text%' or description like '%$search_text%') LIMIT $start,$display";
        $r = mysqli_query($dbc, $q) or trigger_error("error accessing database 16");
        
        //read the results into the results array
        if(mysqli_num_rows($r) > 0){
            while($row = mysqli_fetch_assoc($r)){
                $new_array = array("recipe_id" => $row["recipe_id"], "recipe_name" => $row["name"], "img" => $row["img"], "posted_on" => $row["posted_on"], "description" => $row["description"], "first_name" => $row["first_name"], "last_name" => $row["last_name"], "user_id" => $row['user_id'], "avatar" => $row["avatar"]);
                array_push($results, $new_array);
            }
            //mysqli_free_result($r);
        }
        else{
            $results = NULL;
        }
    }
    if($results != NULL){
      //print the results
      $recipes_counter=0;
      $beginning_of_raw = true;
            
      echo "<div class = \"row bottom-distance-5 justify-content-center\">";
      
      //echo "<h2>we have found ".$total_records." results</h2><br>";
      
      echo "<h3>We have found the following delicious results</h3>";
            
      foreach($results as $recipe){
        $output="";
        $user_name = $recipe["first_name"]." ".$recipe["last_name"];
        $img = cl_image_tag($recipe["img"], array("class" => "img-fluid mx-auto d-block card-img-top", "width"=>250, "height"=>250, "background"=>"black", "crop"=>"pad"));
        if($recipes_counter%3 == 0){
            $output .= "</div>";
            $output .= "<div class = \"row bottom-distance-5 justify-content-center\">";
        }
        $output .=
        "
              <div class=\"card card-spacing\" style=\"width: 18rem;\">$img<div class=\"card-body d-flex flex-column\">
                    <a href = '/view-recipe.php?id=".$recipe['recipe_id']."' class='linked-text'><h5 class=\"card-title\">".$recipe['recipe_name']."</h5></a>
                    ".display_avatar_small($recipe['avatar'], $user_name, $recipe['posted_on'], $recipe['user_id'])."
                    <p class=\"card-text\">".textTruncate($recipe["description"],200)."</p>
                    <a href=\"/view-recipe.php?id=".$recipe["recipe_id"]."\" class=\"btn btn-primary mt-auto\">Go to recipe</a>
                  </div>
              </div>
              ";
            
            $recipes_counter++;
            echo ($output);
            }
            echo "</div>";
      
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
                <a class=\"page-link\" href = \"search.php?s=".($start-$display)."&p=".$pages."&search_text=".$search_text."\">Previous</a>
                ";
                echo "</li>";
            }
            
            //print numbered pages
            for($i=1;$i<=$pages;$i++){
                if($i!=$current_page){
                    echo "<li class=\"page-item\">";
                    echo "<a class=\"page-link\" href=\"search.php?s=".($display*($i-1))."&p=".$pages."&search_text=".$search_text."\">".$i."</a>";
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
                <a class=\"page-link\" href = \"search.php?s=".($start+$display)."&p=".$pages."&search_text=".$search_text."\">Next</a>
                ";
                echo "</li>";
            }
            
            //close pagination container
            echo "</ul></nav>";
            echo "</div>"; //end of row
        }//end of if pages > 1
    }
    else{
        $output = "<div class = \"row justify-content-center align-items-center bottom-distance-5\">
        <h1 class='display-4'>no results found</h1>
        </div>";
        echo $output;
    }
}//end of GET if
?>
<div class="fixed-bottom">
<?php
include "includes/footer.php"
?>
</div>
</div>
</body>
</html>

