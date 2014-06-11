<?php
/**
 * This script can be used to store dildo settings on a remote server.
 *
 * It is NOT IN USE, but an example for how to do it.
 *
 * @author  Ikaros Kappler
 * @date    2014-06-11
 * @version 1.0.0
 **/

header( "Content-Type: text/plain; charset=utf-8" );


// Fetch the params from the GET request.
// (Better send dildo data via HTTP POST?)
$bezier_path = $_GET["bezier_path"];  // A JSON string
$bend        = $_GET["bend"];



// Get user-ID from the current apache session
session_start();
$user_id     = $_SESSION["user_id"]; 




echo "bezier_path=" . $bezier_path . "\n";
echo "bend=" . $bend . "\n";
echo "user_id=" . $user_id . "\n";


// Establish a database connection
$mcon        = mysql_connect( "127.0.0.1",        // MySQL host
			      "dildogenerator",   // user
			      "dildogenerator"    // password
			      );
mysql_select_db( "dildogenerator" );

$query =
  "INSERT INTO dildogenerator.custom_dildos " .
  "( bend, bezier_path, user_id ) " .
  "VALUES ( " .
  "'" . addslashes($bend) . "', " .
  "'" . addslashes($bezier_path) . "', " .
  "'" . addslashes($user_id) . "' ".
  ");";
//echo "Executing query: " . $query . "\n";

if( !mysql_query($query,$mcon) ) {

  echo "Error: " . mysql_error($mcon) . "\n";

} else {

  $insert_id  = mysql_insert_id($mcon);
  echo "Success. Insert-ID=" . $insert_id . "\n";

}



// Don't forget to close the connection!
mysql_close( $mcon );


?>