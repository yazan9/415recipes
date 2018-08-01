<?php
function display_featured_recipes($recipes, $size){
            $size = $size."rem";
            $recipes_counter=0;
            $beginning_of_raw = true;
            
            echo "<div class = \"row bottom-distance-5 justify-content-center\">";
            
            foreach($recipes as $recipe){
              $output="";
              $img = cl_image_tag($recipe["img"], array("class" => "img-fluid mx-auto d-block card-img-top", "crop" => "crop", "gravity"=>"custom"));
  
              if($recipes_counter%3 == 0){
                $output .= "</div>";
                $output .= "<div class = \"row bottom-distance-5 justify-content-center\">";
              }
              
              $old_avatar = "<div class=\"media\">
                      <div class=\"avatar-circle center-elements-in-div\"><span class=\"initials\">JD</span>
                      </div>
                      <div class=\"media-body\">
                        <h5 class=\"mt-0\">".ucwords($recipe["first_name"].' '.$recipe["last_name"])."</h5>
                        <p class=\"posted\">".$recipe["posted_on"]."</p>
                      </div>
                    </div>";
              
              
              
              $output .=
              "
              
              <div class=\"card card-spacing\" style=\"width: $size\">$img<div class=\"card-body d-flex flex-column mt-auto\">
                    <a href = '/view-recipe.php?id=".$recipe['recipe_id']."' class='linked-text'><h2 class=\"card-title\">".$recipe['recipe_name']."</h2></a>
                    ".display_avatar_small($recipe['avatar'], $recipe['first_name']." ".$recipe['last_name'], $recipe['posted_on'], $recipe['user_id'])."
                    <p class=\"card-text description-text\">".textTruncate($recipe["description"],300)."</p>
                  </div>
              </div>
              
              ";
            
            $recipes_counter++;
            echo ($output);
            }
            echo "</div>";
}

function display_yummy_recipes($recipes, $size){
            $size = $size."rem";
            $recipes_counter=0;
            $beginning_of_raw = true;
            
            //to be used if there is no image to display
            $description = "";
            
            echo "<div class = \"row bottom-distance-5 justify-content-center\">";
            
            foreach($recipes as $recipe){
              if($recipe["img"] != ""){
                $img = cl_image_tag($recipe["img"], array("class" => "img-fluid mx-auto d-block card-img-top", "crop" => "crop", "gravity"=>"custom"));
              }
              else{
                $img = "";
                $description = $recipe["description"];
              }
              $output="";
  
              if($recipes_counter%3 == 0){
                $output .= "</div>";
                $output .= "<div class = \"row bottom-distance-5 justify-content-center\">";
              }
              $output .=
              "
              
              <div class=\"card card-spacing\" style=\"width: $size\">$img<div class=\"card-body d-flex flex-column\">
                    <a href = '/view-recipe.php?id=".$recipe['recipe_id']."' class='linked-text'><h2 class=\"card-title\">".$recipe['recipe_name']."</h2></a>
                    ".$description.display_avatar_small($recipe['avatar'], $recipe['first_name']." ".$recipe['last_name'], $recipe['posted_on'], $recipe['user_id'])."
                  </div>
              </div>
              
              ";
            
            $recipes_counter++;
            echo ($output);
            }
            echo "</div>";
}


          ?>