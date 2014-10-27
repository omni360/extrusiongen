<?php

/**
 * This server script delivers the bezier/preview image data (PNG) for the passed record ID.
 *
 * @author   Ikaros Kappler
 * @date     2014-07-24
 * @modified 2014-10-27 Ikaros Kappler (loading images from database into the file system).
 * @version  1.0.1
 **/


if( !$preview_type )
  $preview_type = "bezier";



$public_hash = $_GET["public_hash"];
if( !$public_hash )
  ; // TODO return error code!!!


$filename = "images/" . $public_hash . "." . $preview_type . ".png";

// First check, if the image is stored in the file system
if( file_exists($filename) )  {

  // Just return the image
  header( "Content-Type: image/png" );
  header( "Content-Length: " . filesize($filename) );
  flush();
  readfile( $filename );

} else {
  
  // Establish a database connection
  require_once( "../inc/config.inc.php" );
  require_once( "../inc/function.store_base64_encoded_image_in_filesystem.inc.php" );
  require_once( "../inc/function.mcon.inc.php" );
  $mcon = mcon();





  $query =
    "SELECT " . addslashes($preview_type) . "_image " .
    "FROM custom_dildos " .
    "WHERE public_hash = '" . addslashes($public_hash) . "' " .
    "LIMIT 1;";
  //echo $query;

  $result = mysql_query( $query, $mcon );
  if( !$result ) {

    echo "Failed to query " . $preview_type. "_image: " . mysql_error($mcon) . ".\n";

  } else {

    $row = mysql_fetch_assoc($result);
    mysql_free_result( $result );

    if( !$row ) {

      // Send error status (not found)
      header( "HTTP/1.1 404 Not Found", TRUE ); 
      echo "Error: hash not found.";

    } else {

      $data_base64 = $row[ $preview_type . "_image" ];  // "preview_image"
      $data_base64_raw = substr( $data_base64, 22 );
 
      // Write raw image data to file system and delete from database?
      $config_key = "STORE_" . strtoupper($preview_type) . "_IMAGES_IN_FILESYSTEM";
      if( $_DILDO_CONFIG["gallery_settings"][$config_key] && 
	  $row 
	  ) {
	

	list( $rc,
	      $err ) = store_base64_encoded_image_in_filesystem( "images/" . $public_hash . "." . $preview_type . ".png",
								 $data_base64_raw // substr( $data_base64, 22 )
								 );
	if( $rc != 0 ) {
	  $errmsg = "Failed to store bezier image '" . $public_hash . "' in file system: " . $err . "\n";
	  header( "HTTP/1.1 500 " . $errmsg, TRUE ); 
	  echo $errmsg;

	  mail( $your_mail_address, 
		"Failed to transfer dildo image data!", 
		"Failed to transfer dildo image data (" . $preview_type . ") to file system\n" .
		$errmsg 
		);
	} else {

	  
	  // Delete image data from database
	  $query = 
	    "UPDATE custom_dildos " .
	    "SET " . addslashes($preview_type) . "_image = '' " .
	    "WHERE public_hash = '" . addslashes($public_hash) . "' " .
	    "LIMIT 1;";
	  if( !mysql_query($query,$mcon) ) {

	    $errmsg = "Failed drop " . $preview_type . " image '" . $public_hash . "' from database: " . mysql_error($mcon) . "\n";
	    header( "HTTP/1.1 500 " . $errmsg, TRUE ); 
	    echo $errmsg;
	    mysql_close( $mcon );
	    die();


	    mail( $your_mail_address, 
		  "Failed to drop dildo image data!", 
		  "Failed to drop dildo image data (" . $preview_type . ") from database\n" .
		  mysql_error($mcon)
		  );
	  
	  }
	  

	}

      }

    
      // Cut off the 'data:image/png;base64,' part to get the pure base64 data
      //$base64_raw = substr( $data_base64, 22 );
      //echo $base64_raw;
    
    
      header( "Content-Type: image/png" );
      //echo "base64=" . $data_base64_raw;
      
      echo base64_decode( $data_base64_raw,
			  false //true         // strict (will cause error if not base64)
			  );
      
    
    
    }

  }


  mysql_close( $mcon );

} // END else [file did not exist in file system]


?>