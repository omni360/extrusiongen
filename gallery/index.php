<!DOCTYPE html>
<html> 
<head> 
<title>Extrusion and Revolution Solids - A Dildo Generator</title> 
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="A bleeding edge HTML5/WebGL/THREE.js dildo generator for 3D printing." />
<meta name="author" content="Ikaros Kappler" />
<meta name="keywords" content="dildo, generator, three.js, webgl, html5, bleeding edge, dildo generator, javascript" />
<link rel="stylesheet" type="text/css" media="screen" href="../style.css" />

<style type="text/css" media="screen">
  body {
  background-color: #f8f8f8;
  }
</style>

</head>

<body>

<h1>Dildo-Generator - Gallery</h1>
<?php

/**
 * This server script displays the gallery (the collection of stored dildo designs, which
 * reside in the database).
 *
 * @author  Ikaros Kappler
 * @date    2014-07-17
 * @version 1.0.0
 **/


// Establish a database connection
require_once( "../inc/function.mcon.inc.php" );
$mcon = mcon();


$public_hash = FALSE;
if( array_key_exists("public_hash",$_GET) )
  $public_hash = $_GET["public_hash"];




$query =
  "SELECT * " .
  "FROM custom_dildos ";

if( $public_hash )
  $query .= "WHERE public_hash = '" . addslashes($public_hash) . "' ";

$query .=
  "ORDER BY id DESC;";

$result = mysql_query( $query, $mcon );
if( !$result ) {

  echo "<div class=\"error\">Failed to query stored dildos: " . mysql_error($mcon) . ".</div>\n";

} else {

  $columnCount = 6;
  $i           = 0;
  echo "<table border=\"0\">\n";
  while( $row = mysql_fetch_assoc($result) ) {

    if( $i % $columnCount == 0 ) {
      if( $i > 0 )
	echo "</tr>\n";
      echo "   <tr>\n";
    }
    //print_r( $row );
    //echo "      <td><img src=\"" . $row["preview_image"] . "\" width=\"256\" height=\"384\" alt=\"preview#" . $row["id"] . "\"/></td>\n";
    
    echo 
      "      <td>\n";
    
    if( $public_hash ) {
      echo
	   
	"         <img src=\"getPreviewImage.php?public_hash=" . $row["public_hash"] . "\" width=\"512\" height=\"768\" alt=\"dildo preview #" . $row["id"] . "\"/>\n";
    } else {
      echo 
	"         <a href=\"?public_hash=" . $row["public_hash"] . "\">" . 
	"         <img src=\"getPreviewImage.php?public_hash=" . $row["public_hash"] . "\" width=\"128\" height=\"192\" alt=\"dildo preview #" . $row["id"] . "\"/>\n" .
	"         </a>\n";
    }

    echo
      "         <br/>\n" .
      "         <b>" . $row["name"] . "</b><br/>\n".
      "         Creator: " . $row["user_name"] . "<br/>\n" .
      "         Date: " . date("Y-m-d H:i:s", $row["date_created"]) . "<br/>\n";

    if( $row["hide_email_address"] != 'Y' )
      echo "         Email: " . $row["email_address"] . "<br/>\n";

    echo
      "      </td>\n";
    if( $row["id"] == 50 )
      ; //echo "<td>" . $row["preview_image"] . "</td>\n";
    
    
    $i++;
    
  }

  mysql_free_result( $result );

}

if( $public_hash )
  echo "<a href=\"?\">&larr; back</a><br/>\n";


mysql_close( $mcon );


?>

</body>
</html>