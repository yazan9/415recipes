$(function(){
    $('#add_step_button').click(function(e){
        //count the number of steps so far + 1
        var step_no = $('#recipe_steps .steps_input').length+1;
        
        //add input for the new step
        var new_step = "<div class=\"form-row bottom-distance-5\" id=\"new_step_div_" + step_no +"\">";
        
        new_step += "<div class=\"form-group col-md-11\">";
        new_step += "<label for=\"new_step_"+step_no+"\" class=\"modal-text steps_input\">Step "+"</label><textarea class=\"form-control\" id=\"new_step_"+step_no+"\" name=\"new_step_"+step_no+"\" rows=\"3\"></textarea>";
        new_step += "</div>"; //end of column
        
        new_step+= "<div class=\"form-group col-md-1\">";
        new_step += "<button type=\"button\" class=\"btn btn-large btn-outline-danger\" onclick=\"RemoveStep(" + step_no +");\">x</button>";
        new_step += "</div>";//end of column
        
        new_step+= "</div>"; //end of row
        
        $('#recipe_steps').append(new_step);
        //alert($('#recipe_steps .steps_input').length);
     });
     
     $('#add_note_button').click(function(e){
        //count the number of notes so far + 1
        var note_no = $('#recipe_notes .notes_input').length+1;
        
        //add input for the new note
        var new_note = "<div class=\"form-row bottom-distance-5\" id=\"new_note_div_" + note_no +"\">";
        
        new_note += "<div class=\"form-group col-md-11\">";
        new_note += "<label for=\"new_note_"+note_no+"\" class=\"modal-text notes_input\">Note "+"</label><textarea class=\"form-control\" id=\"new_note_"+note_no+"\" name=\"new_note_"+note_no+"\" rows=\"3\"></textarea>";
        new_note += "</div>"; //end of column
        
        new_note+= "<div class=\"form-group col-md-1\">";
        new_note += "<button type=\"button\" class=\"btn btn-large btn-outline-danger\" onclick=\"RemoveNote(" + note_no +");\">x</button>";
        new_note += "</div>";//end of column
        
        new_note+= "</div>"; //end of row
        
        $('#recipe_notes').append(new_note);
        //alert($('#recipe_steps .steps_input').length);
     });
     
     $('#add_ingredient_button').click(function(e){
        //count the number of ingredients so far + 1
        var ingredient_no = $('#recipe_ingredients .ingredients_input').length+1;
        
        //add input for the new ingredient
        var new_ingredient = "<div class=\"form-row bottom-distance-5\" id=\"new_ingredient_div_" + ingredient_no +"\">";
        new_ingredient+= "<div class=\"form-group col-md-11\">";
        new_ingredient+= "<label for=\"Ingredient\" class=\"modal-text ingredients_input\">Ingredient</label>";
        new_ingredient+= "<input class=\"form-control form-control-lg\" id=\"new_ingredient_" + ingredient_no + "\" name=\"new_ingredient_" + ingredient_no + "\" placeholder=\"What is it?\" type=\"text\"/>";
        new_ingredient+= "</div>"; //end of column
        
        new_ingredient+= "<div class=\"form-group col-md-1\">";
        new_ingredient+= "<button type=\"button\" class=\"btn btn-large btn-outline-danger remove_button\" onclick=\"RemoveIngredient("+ingredient_no+");\">x</button>";
        new_ingredient+= "</div>"; //end of column
        
        new_ingredient+= "</div>"; //end of row
        
        $('#recipe_ingredients').append(new_ingredient);
        //alert($('#recipe_steps .steps_input').length);
     });
     
     $('#edit_recipe_form').submit(function(e){
        //start validation
        var flag = true;
        
        //remove error messages: new submission
        $('#RecipeName').removeClass('is-invalid');
        $('#add_recipe_errors_div').hide();
        $('#add_recipe_errors_div').html("");
        
        //check if a name was entered
        if($('#RecipeName').val().trim() == ""){
            $('#RecipeName').addClass('is-invalid');
        }
        
        //check if at least one ingredient was entered
        var ingredient_no = $('#recipe_ingredients .ingredients_input').length;
        if(ingredient_no == 0){
            flag = false;
            $('#add_recipe_errors_div').append("<p>+You must enter at least one ingredient</p>");
        }
        else{
            //all correct
        }
        
        //check if at least one step was entered
        var step_no = $('#recipe_steps .steps_input').length;
        if(step_no == 0){
            flag = false;
            $('#add_recipe_errors_div').append("<p>+You must enter at least one step");
        }
        else{
            //all correct
        }
        
        //intercept submission:
        e.preventDefault();
        
        if(flag == false){
            //show errors
            $('#add_recipe_errors_div').show();
            
            //animate scroll to the top of the page
            $("html, body").animate({ scrollTop: 0 }, 500);
            return false;
        }
        else{
            //submit the form
            document.getElementById("edit_recipe_form").submit();
            return true;
        }
     });
});
