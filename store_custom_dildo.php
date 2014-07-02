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
 * @version  1.0.2
 **/

header( "Content-Type: text/plain; charset=utf-8" );


// Fetch the params from the GET or the POST request.
// (Better send dildo data via HTTP POST?)
if( $_SERVER['REQUEST_METHOD'] == "POST" ) {
  $bend        = $_POST["bend"];
  $id          = $_POST["id"];
  $bezier_path = $_POST["bezier_path"];

} /*else if( $_SERVER['REQUEST_METHOD'] == "GET" ) {
  $bend        = $_GET["bend"];
  $id          = $_GET["id"];
  $bezier_path = $_GET["bezier_path"];  // A JSON string
  */
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
$mcon        = mysql_connect( "127.0.0.1",        // MySQL host
			      "dildogenerator",   // user
			      "dildogenerator"    // password
			      );
mysql_select_db( "dildogenerator" );


// INSERT or UPDATE?
$query    = "";
if( !$id || $id == -1 ) {
  $query =
    "INSERT INTO dildogenerator.custom_dildos " .
    "( bend, bezier_path, user_id ) " .
    "VALUES ( " .
    "'" . addslashes($bend) . "', " .
    "'" . addslashes($bezier_path) . "', " .
    "'" . addslashes($user_id) . "' ".
    ");";

} else {
  $query = 
    "UPDATE dildogenerator.custom_dildos SET " .
    "bend        = '" . addslashes($bend) . "', " .
    "bezier_path = '" . addslashes($bezier_path) . "' " .
    //"user_id     = '" . addslashes($user_id) . "', " .
    "WHERE id = '" . addslashes($id) . "' ".
    "AND   user_id = '" . addslashes($user_id) . "' " .
    "LIMIT 1;";

}
//echo "Executing query: " . $query . "\n";

if( !mysql_query($query,$mcon) ) {

  header( "HTTP/1.1 500 Internal Server Error", TRUE ); 
  echo "Error: " . mysql_error($mcon) . "\n";

} else if( $id && $id != -1 ) {

  // NOOP

} else {
  
  $id  = mysql_insert_id($mcon);

}


echo $id;




// Don't forget to close the connection!
mysql_close( $mcon );


?>