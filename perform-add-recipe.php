<?php
require "includes/pre-html.php";
require "includes/config.inc.php";
?>
<?php 
//check if user logged in:
if (!is_logged_in()){
  header("Location:/login-modal.php");
  exit();
}
?>
<?php
//if a form is being submitted
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //various arrays:
    $errors = array();
    $time_units = array("Seconds", "Minutes", "Hours", "Days");
    $ingredients = array();
    $steps = array();
    $notes = array();
    $current_user_id = $_SESSION["user_id"];
    
    //open database connection
    require('mysqli_connect.php');
    
    //assume invalid values for validation
    $recipe_name = $recipe_description = $cook_time = $cook_unit = $prep_time = $prep_unit = $serves = FALSE;
    
    //perform validations:
    
    //1. validate recipe name
    if(trim(strlen($_POST['RecipeName']))>=1){
        $recipe_name = mysqli_real_escape_string($dbc, $_POST['RecipeName']);
    }
    else{
        array_push($errors,"Invalid recipe_name");
        //exit();
    }
    
    //2. check that at least one ingredient exists
    $no_ingredients = true;
    foreach($_POST as $key => $val)
    {
        //user added an ingredient
        if(startsWith($key, 'new_ingredient_')){

            //read ingredient number:
            $ingredient_number = substr($key, 15);
            
            //get ingredient description:
            $ingredient_description = mysqli_real_escape_string($dbc, $_POST[$key]);

            //check all values
            if(trim(strlen($ingredient_description))>0){
                array_push($ingredients, $ingredient_description);
                $no_ingredients = false;
            }
        }
    }

    if($no_ingredients == true){
        array_push($errors ,"Please enter at least one ingredient");
    }
    
    //3. check that at least one step exists
    $no_steps = true;
    foreach($_POST as $key => $val)
    {
        //user entered a step:
        if(startsWith($key, 'new_step_')){
            
            //get the step:
            $step = mysqli_real_escape_string($dbc, $_POST[$key]);
            
            //check if the step is not empty:
            if(trim(strlen($step))>0){
                array_push($steps, $step);
                $no_steps = false;
            }
        }
    }
    if($no_steps == true){
        array_push($errors ,"Please enter at least one step");
    }
    
    //4. validate cooking time - if supplied
    if($_POST['CookTime']!=NULL && !is_numeric($_POST['CookTime'])){
        array_push($errors, "Wrong value for Cooking Time");
    }
    //5. validate cooking unit - if supplied, and only after cooking time is supplied
    else if($_POST['CookTimeUnit']!=0 && !in_array($_POST['CookTime'], $time_units)){
        array_push($errors, "Wrong value for Cooking Time Unit");
    }
    //if all is well, set the data
    else{
        $cook_time = $_POST['CookTime'];
        $cook_unit = $_POST['CookTimeUnit'];
    }
    
    //5. validate prep time - if supplied
    if($_POST['PrepTime']!=NULL && !is_numeric($_POST['PrepTime'])){
        array_push($errors, "Wrong value for Preparation Time");
    }
    //validate prep unit - if supplied, and only after preparation time is supplied
    else if($_POST['PrepTimeUnit']!=0 && !in_array($_POST['PrepTimeUnit'], $time_units)){
        array_push($errors, "Wrong value for Preparation Time Unit");
    }
    //if all is well, set the data
    else{
        $prep_time = $_POST['PrepTime'];
        $prep_unit = $_POST['PrepTimeUnit'];
    }
    
    //6. validate Serves value - if supplied
    if(!((int)($_POST['Serves']) >= 0 && (int)($_POST['Serves']<=8))){
        array_push($errors, "Wrong value for how many people this recipe serves");
    }
    else{
        $serves = $_POST['Serves'];
    }
    
    //7. clean up incoming recipe description:
    $recipe_description = mysqli_real_escape_string($dbc, $_POST['RecipeDescription']);
    
    //8. clean up any notes provided:
    foreach($_POST as $key => $val)
    {
        //user entered a note:
        if(startsWith($key, 'new_note_')){
            
            //get the note:
            $note = mysqli_real_escape_string($dbc, $_POST[$key]);
            
            //check that the note is not empty:
            if(trim(strlen($note))>0){
                array_push($notes, $note);
            }
        }
    }
    
    //9. clean up image value, if exists
    if(isset($_POST["img"])){
        $img = mysqli_real_escape_string($dbc, $_POST['img']);
    }
    else{
        $img = NO_IMAGE_RECIPE;
    }
    
    if(!empty($errors)){
        print_r(array_values($errors));
    }
    else{
        
        //sanitize inputs to allow for NULLs
        $recipe_description = $recipe_description == ""? 'NULL' : "'$recipe_description'";
        $cook_unit = $cook_time == ""? 'NULL' : "'$cook_unit'";
        $prep_unit = $prep_time == ""? 'NULL' : "'$prep_unit'";
        
        //set the time now
        $posted_on = date('Y-m-d H:i:s');
        
        //start a transaction
        mysqli_begin_transaction($dbc);
        
        //build the query for the recipe
        $q = "INSERT INTO recipes (name, description, cook_time, cook_unit, prep_time, prep_unit, serves, posted_on, user_id, img) VALUES ('$recipe_name', $recipe_description, '$cook_time', $cook_unit, '$prep_time', $prep_unit, '$serves', '$posted_on', '$current_user_id', '$img')";
        $r = mysqli_query($dbc,$q) or trigger_error(mysqli_error($dbc));
        
        if(!$r){
            //something went wrong
        }
        
        //get the ID of the inserted recipe
        $recipe_id = mysqli_insert_id($dbc);
        
        //build the query for multiple ingredients
        $q2 = "INSERT INTO ingredients (recipe_id, name) VALUES";
        foreach($ingredients as $ingredient){
            $q2.= "('$recipe_id','$ingredient'),";
        }
        
        //remove the last comma
        $q2 = rtrim($q2, ',');
        
        //insert into the DB
        $r2 = mysqli_query($dbc,$q2);
        
        if(!$r2){
            //something went wrong
        }
        
        //process steps
        //build the query for multiple notes
        $q3 = "INSERT INTO steps (recipe_id, description) VALUES";
        foreach($steps as $step){
            $q3.= "('$recipe_id','$step'),";
        }
        
        //remove the last comma
        $q3 = rtrim($q3, ',');
        
        //insert into the DB
        $r3 = mysqli_query($dbc,$q3);
        
        if(!$r3){
            //something went wrong
        }
        
        //process notes
        //check for multiple notes:
        if(count($notes)>0){
            //build the query
            $q4 = "INSERT INTO notes (recipe_id, description) VALUES";
            
            foreach($notes as $note){
                $q4.= "('$recipe_id','$note'),";
            }
        
            //remove the last comma
            $q4 = rtrim($q4, ',');
        
            //insert into the DB
            $r4 = mysqli_query($dbc,$q4);
        
            if(!$r4){
                //something went wrong
            }   
        }
        
        //commit changes:
        mysqli_commit($dbc);
        header("location:/view-recipe.php?id=$recipe_id");
    }
}
?>