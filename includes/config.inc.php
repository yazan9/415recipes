<?php

// Flag variable for site status:
define('LIVE', FALSE);

// Admin contact address:
define('EMAIL', 'yazan.khalaileh@gmail.com');

// Site URL (base for all redirections):
define ('BASE_URL', "https://recipes415-chilivote.c9users.io/");

// Location of the MySQL connection script:
define ('MYSQL', 'mysqli_connect.php');

// Adjust the time zone for PHP 5.1 and greater:
date_default_timezone_set ('US/Western');

// ************ SETTINGS ************ //
// ********************************** //
$time_units = array("Seconds", "Minutes", "Hours", "Days");
$quantity_units = array("gm", "kg", "lt", "lbs", "ml", "tsp", "tbsp", "unit/other");

//Cloudinary
require 'vendor/cloudinary/cloudinary_php/src/Cloudinary.php';
require 'vendor/cloudinary/cloudinary_php/src/Uploader.php';
require 'vendor/cloudinary/cloudinary_php/src/Api.php';

\Cloudinary::config(array(
  "cloud_name" => "dzv1zwbj5", 
  "api_key" => "672873823841822", 
  "api_secret" => "r2csBYQCb3R3cW0cPkc7OBKhCR4" 
));

// ************ FUNCTIONS ************ //
// ********************************** //
function is_logged_in(){
	if(isset($_SESSION['user_id'])){
		return true;
	}
	else{
		return false;
	}
}

function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}

function recipe_belongs_to_user($recipe_id, $user_id, $dbc){
	//build the query
	$q = "SELECT recipe_id FROM recipes WHERE recipe_id='$recipe_id' AND user_id = '$user_id'";
	$r = mysqli_query($dbc,$q) or trigger_error("error connecting to database 009");
	if(mysqli_num_rows($r) == 1){
		return true;
	}
	else return false;
}

function textTruncate($string, $desired_width) {
  $parts = preg_split('/([\s\n\r]+)/', $string, null, PREG_SPLIT_DELIM_CAPTURE);
  $parts_count = count($parts);

  $length = 0;
  $last_part = 0;
  for (; $last_part < $parts_count; ++$last_part) {
    $length += strlen($parts[$last_part]);
    if ($length > $desired_width) { break; }
  }

  return implode(array_slice($parts, 0, $last_part));
}

function display_avatar_small($img, $username, $posted, $user_id){
	$output = "";
	if($img!= NULL){
		$output = "<div>".cl_image_tag($img, array("class" => "float-left margin-2","transformation"=>array(
		array("width"=>48, "height"=>48, "gravity"=>"face", "radius"=>"max", "crop"=>"fill"),
		array("width"=>48, "crop"=>"fill")
	)))."<h5><a class='linked-text' href='/view-profile.php?id=".$user_id."'>".ucwords($username)."</a></h5><p class=\"posted\">".$posted."</p></div>";
	}
	else{
		//break the username into initials
		$words = explode(" ", $username);
		$initials = "";

		foreach ($words as $w) {
			$initials .= $w[0];
		}
		$initials = substr($initials, 0, 2);
		
		$output = "<div class=\"media\">
                      <div class=\"avatar-circle center-elements-in-div\"><span class=\"initials\">".$initials."</span>
                      </div>
                      <div class=\"media-body\">
                        <h5 class=\"mt-0\"><a class='linked-text' href='/view-profile.php?id=".$user_id."'>".ucwords($username)."</a></h5>
                        <p class=\"posted\">".$posted."</p>
                      </div>
                    </div>";
	}
	return $output;
}

function display_avatar_big($avatar, $username){
	if($avatar!= NULL){
		$output =	cl_image_tag($avatar, array("transformation"=>array(
		array("width"=>150, "height"=>150, "gravity"=>"face", "radius"=>"max", "crop"=>"fill"),
		array("width"=>150, "crop"=>"fill")
		)));
	}
	else{
		//break the username into initials
		$words = explode(" ", $username);
		$initials = "";

		foreach ($words as $w) {
			$initials .= $w[0];
		}
		$initials = substr($initials, 0, 2);
		
		$output = "<div class=\"media\">
                      <div class=\"avatar-circle-big center-elements-in-div\"><span class=\"initials-big\">".$initials."</span>
                      </div>
         </div>";
	}
	return $output;
}

// ****************************************** //
// ************ ERROR MANAGEMENT ************ //

// Create the error handler:
function my_error_handler ($e_number, $e_message, $e_file, $e_line, $e_vars) {

	// Build the error message:
	$message = "An error occurred in script '$e_file' on line $e_line: $e_message\n";
	
	// Add the date and time:
	$message .= "Date/Time: " . date('n-j-Y H:i:s') . "\n";
	
	if (!LIVE) { // Development (print the error).

		// Show the error message:
		echo '<div class="error">' . nl2br($message);
	
		// Add the variables and a backtrace:
		echo '<pre>' . print_r ($e_vars, 1) . "\n";
		debug_print_backtrace();
		echo '</pre></div>';
		
	} else { // Don't show the error:

		// Send an email to the admin:
		//$body = $message . "\n" . print_r ($e_vars, 1);
		//mail(EMAIL, 'Site Error!', $body, 'From: email@example.com');
	
		// Only print an error message if the error isn't a notice:
		if ($e_number != E_NOTICE) {
			echo '<div class="error">A system error occurred. We apologize for the inconvenience.</div><br />';
		}
	} // End of !LIVE IF.

} // End of my_error_handler() definition.

// Use my error handler:
set_error_handler ('my_error_handler');

// ************ ERROR MANAGEMENT ************ //
// ****************************************** //