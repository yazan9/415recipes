<?php

// Set the database access information as constants:
DEFINE ('DB_USER', 'b03be54a148811');
DEFINE ('DB_PASSWORD', '7df1de44');
DEFINE ('DB_HOST', 'us-cdbr-iron-east-04.cleardb.net');
DEFINE ('DB_NAME', 'heroku_1ff56ad2e674a12');

// Make the connection:
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// If no connection could be made, trigger an error:
if (!$dbc) {
	trigger_error ('Could not connect to MySQL: ' . mysqli_connect_error() );
} else { // Otherwise, set the encoding:
	mysqli_set_charset($dbc, 'utf8');
}