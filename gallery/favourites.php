<!DOCTYPE html>
<html> 
<head> 
<title>User Created 3D Model</title> 
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="A bleeding edge HTML5/WebGL/THREE.js dildo generator for 3D printing." />
<meta name="author" content="Ikaros Kappler" />
<meta name="keywords" content="dildo, generator, three.js, webgl, html5, bleeding edge, dildo generator, javascript" />
<link rel="stylesheet" type="text/css" media="screen" href="../style.css" />

<style type="text/css" media="screen">
   body {
   background-color: #f8f8f8;
 margin:             35px; 
  }
</style>

<body>
<h2>Dildo-Generator Gallery: Favourites</h2>
<a href="http://www.dildo-generator.com">Back to the Dildo-Generator</a><br/>
<a href="index.php">&larr; to the gallery</a><br/>
<br/>
<br/>

<?php

/**
 * @author  Ikaros Kappler
 * @date    2014-11-05
 * @version 1.0.0
 **/

require_once( "favourites.inc.php" );
require_once( "../inc/function.mcon.inc.php" );
$mcon = mcon();

if( !$mcon ) {

  echo "Failed to establish database connection.<br/>\n";

} else {

  $query_dump =
    "SELECT * FROM custom_dildos WHERE ";
  
  $e = 0;
  foreach( $_GALLERY_FAVOURITES as $section_name => $hashes ) {
    
    $query =
      "SELECT * FROM custom_dildos WHERE ";
    
    $i = 0;
    foreach( $hashes as $h ) {
    
      /*
	echo "<a href=\"http://www.dildo-generator.com/gallery/?public_hash=" . $h . "\" target=\"_blank\">\n";
	echo "         <img src=\"http://www.dildo-generator.com/gallery/getPreviewImage.php?public_hash=" . $h . "\" width=\"512\" height=\"768\" alt=\"dildo preview #" . $h . "\"/><br/>\n";
	echo "</a><br/>\n";
      */
      
      if( $i > 0 ) {
	$query .= " OR";
      }
      if( $e > 0 )
	$query_dump .= " OR";
      
      $query .= " public_hash = '" . addslashes($h) . "'";
      $query_dump .= " public_hash = '" . addslashes($h) . "'";
      
      $i++;
      $e++;
      
    }
    
    $query .= ";";
    // $query_dump .= ";";
    /*
    echo "Dump:";
    echo "<code>" . $query_dump . "</code>\n";
    echo "<br/>\n";
    */

    $result = mysql_query( $query, $mcon );
    if( !$result ) {

      echo "<div class=\"error\">Failed to query gallery records.</div>\n";

    } else { 
      
      //if( count($hashes) > 1 )
      echo "<h3>" . $section_name . "</h3>\n";

      while( $row = mysql_fetch_assoc($result) ) {

	echo "<a href=\"http://www.dildo-generator.com/gallery/?public_hash=" . $row["public_hash"] . "\" target=\"_blank\">\n";
	echo $row["name"] . "<br/>\n";
	echo "         <img src=\"http://www.dildo-generator.com/gallery/getPreviewImage.php?public_hash=" . $row["public_hash"] . "\" width=\"512\" height=\"768\" alt=\"dildo preview #" . $row["public_hash"] . "\"/><br/>\n";
	echo "</a><br/>\n";
	

      }

      mysql_free_result( $result );

    }
    
  }

  mysql_close( $mcon );

} // END else [db connection established]

/*
echo "Dump:<br>\n";                                                                                                                              
echo "<code>" . $query_dump . "</code>\n";                                                                                                 
echo "<br/>\n";   
*/
?>
</body>
</html>
