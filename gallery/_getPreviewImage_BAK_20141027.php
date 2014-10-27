<?php

/**
 * This server script delivers the 3d preview image data (PNG) for the passed record ID.
 *
 * @author  Ikaros Kappler
 * @date    2014-07-17
 * @version 1.0.0
 **/


$public_hash = $_GET["public_hash"];
if( !$public_hash )
  ; // TODO return error code!!!

// Establish a database connection
require_once( "../inc/function.mcon.inc.php" );
$mcon = mcon();


$query =
  "SELECT preview_image FROM custom_dildos WHERE public_hash = '" . addslashes($public_hash) . "' LIMIT 1;";

$result = mysql_query( $query, $mcon );
if( !$result ) {

  echo "<div class=\"error\">Failed to query preview_image: " . mysql_error($mcon) . ".</div>\n";

} else {

  $row = mysql_fetch_assoc($result);
  mysql_free_result( $result );

  if( !$row ) {

    // Send error status (not found)

  } else {

    //header( "Content-Type: text/plain;base64;charset=UTF-8" ); //;charset=ISO-8859-1" );
    //header( "Content-Type: image/png;base64" );
    

    $data_base64 = $row["preview_image"];
    //echo $data_base64;

    
    // Cut off the 'data:image/png;base64,' part to get the pure base64 data
    $base64_raw = substr( $data_base64, 22 );
    //echo $base64_raw;
    
    
    header( "Content-Type: image/png" );
    
      echo base64_decode( $base64_raw,
			  false //true         // strict (will cause error if not base64)
			);
    
    
    
  }

}


mysql_close( $mcon );


?>