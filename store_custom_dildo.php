<?php
/**
 * This script can be used to store dildo settings on a remote server.
 *
 * It is NOT IN USE, but an example for how to do it.
 *
 * @author   Ikaros Kappler
 * @date     2014-06-11
 * @modified 2014-07-01 Ikaros Kappler (added the UPDATE function for remote storage, if $id is passed).
 * @modified 2014-07-02 Ikaros Kappler (changed the submit method to HTTP POST).
 * @modified 2014-07-13 Ikaros Kappler (added IP check).
 * @modified 2014-07-16 Ikaros Kappler (added additional publishing data: user_name, email_address, ...).
 * @version  1.0.2
 **/

header( "Content-Type: text/plain; charset=utf-8" );


// Configure access control to avoid Cross-Site-Scripting exploits
// THIS SOMEHOW DOES NOT YET WORK!
/* 
header( "Access-Control-Allow-Origin: " .

	"http://www.dildo-generator.com " .
	"http://www.dildogenerator.com " .
	"http://dildo-generator.com" .
	"http://dildogenerator.com" 
	);
*/




// Fetch the params from the GET or the POST request.
// (Better send dildo data via HTTP POST?)
if( $_SERVER['REQUEST_METHOD'] == "POST" ) {
  $bend               = $_POST["bend"];
  $id                 = $_POST["id"];
  $public_hash        = $_POST["public_hash"];
  $bezier_path        = $_POST["bezier_path"];
  $dildo_name         = $_POST["dildo_name"];
  $user_name          = $_POST["user_name"];
  $email_address      = $_POST["email_address"];
  $hide_email_address = $_POST["hide_email_address"];
  $allow_download     = $_POST["allow_download"];
  $allow_edit         = $_POST["allow_edit"];
  $image_data         = $_POST["image_data"];
  $originb64          = $_POST["originb64"];

} else {
  header( "HTTP/1.1 405 Method Not Allowed", TRUE ); 
  die( "The requested method '" . $_SERVER['REQUEST_METHOD'] . "' is not allowed here.\n" );

}


if( $id && !is_numeric($id) ) {
  header( "HTTP/1.1 400 Bad Request", TRUE ); 
  die( "The passed ID '" . $id . "' is not numeric.\n" );
}


// Get user-ID from the current apache session
session_start();
$user_id     = $_SESSION["user_id"]; 



// Establish a database connection
require_once( "inc/function.mcon.inc.php" );
$mcon = mcon();


// INSERT or UPDATE?
$query    = "";
if( !$id || $id == -1 || !$public_hash ) {

  // Make a public hash
  $salt = rand(0, 65535);
  $time = time();
  $raw  = $bend . "#" . $salt . "$" . $time . "*" . $name . "/" . $user_name . "\"" . $user_id . "-" . $origin_b64;
  $public_hash = md5($raw);
  
  // Restore original base64 data (was modified for HTTP POST transfer)
  $image_data_clean = str_replace( array("-", "_"), //  "\"",   "'"), 
				   array("+", "/"), // "\\\"", "\\'"), 
				   $image_data 
				   );

  $query =
    "INSERT INTO dildogenerator.custom_dildos " .
    "( bend, bezier_path, user_id, name, user_name, email_address, hide_email_address, allow_download, allow_edit, preview_image, public_hash ) " .
    "VALUES ( " .
    "'" . addslashes($bend) . "', " .
    "'" . addslashes($bezier_path) . "', " .
    "'" . addslashes($user_id) . "', ".
    "'" . addslashes($dildo_name) . "', " .
    "'" . addslashes($user_name) . "', " .
    "'" . addslashes($email_address) . "', " .
    "'" . ($hide_email_address ? 'Y' : 'N') . "', " .
    "'" . ($allow_download ? 'Y' : 'N') . "', " .
    "'" . ($allow_edit ? 'Y' : 'N') . "', " .
    "'" . addslashes($image_data_clean) . "', " .
    "'" . addslashes($public_hash) . "' " .
    ");";

} else {
  $query = 
    "UPDATE dildogenerator.custom_dildos SET " .
    "bend               = '" . addslashes($bend) . "', " .
    "bezier_path        = '" . addslashes($bezier_path) . "', " .
    //"user_id            = '" . addslashes($user_id) . "', " .
    "name               = '" . addslashes($dildo_name) . "', " .
    "user_name          = '" . addslashes($user_name) . "', " .
    "email_address      = '" . addslashes($email_address) . "', " .
    "hide_email_address = '" . ($hide_email_address ? 'Y' : 'N') . "', " .
    "allow_download     = '" . ($allow_download ? 'Y' : 'N') . "', " .
    "allow_edit         = '" . ($allow_edit ? 'Y' : 'N') . "', " .
    "preview_image      = '" . addslashes($image_data) . "' " .
    "WHERE id           = '" . addslashes($id) . "' ".
    "AND   public_hash  = '" . addslashes($public_hash) . "' " .
    "AND   user_id = '" . addslashes($user_id) . "' " .
    "LIMIT 1;";

}
//echo "Executing query: " . $query . "\n";

if( !mysql_query($query,$mcon) ) {

  header( "HTTP/1.1 500 Internal Server Error", TRUE ); 
  echo "Error: " . mysql_error($mcon) . "\n";

} else if( $id && $id != -1 ) {

  // This was an update. NOOP
  

} else {
  
  $id  = mysql_insert_id($mcon);

}


//echo $id . " " . $image_data; // $public_hash;
echo $id . " " . $public_hash;


// Don't forget to close the connection!
mysql_close( $mcon );


?>