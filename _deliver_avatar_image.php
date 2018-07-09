<?php
require "includes/config.inc.php";

echo cl_image_tag($_GET["img"], array("transformation"=>array(
  array("width"=>150, "height"=>150, "gravity"=>"face", "radius"=>"max", "crop"=>"fill"),
  array("width"=>150, "crop"=>"fill")
  )));;
?>