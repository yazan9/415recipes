<?php

// Set the database access information as constants:
DEFINE ('DB_USER', 'webuser');
DEFINE ('DB_PASSWORD', 'password1234');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'recipes');

// Make the connection:
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// If no connection could be made, trigger an error:
if (!$dbc) {
	trigger_error ('Could not connect to MySQL: ' . mysqli_connect_error() );
} else { // Otherwise, set the encoding:
	mysqli_set_charset($dbc, 'utf8');
}