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
<script language="Javascript" type="text/javascript" src="../three.js"></script>
<script language="Javascript" type="text/javascript" src="../IKRS.js"></script>
<script language="Javascript" type="text/javascript" src="../IKRS.Object.js"></script>
<script language="Javascript" type="text/javascript" src="../IKRS.CubicBezierCurve.js"></script>
<script language="Javascript" type="text/javascript" src="../IKRS.BezierPath.js"></script>
<script language="Javascript">
   function loadDildo( id, 
		       public_hash, 
		       bend, 
		       bezier_JSON
		       ) {
   
   // Replace ' by ".
   // The parser function requires double quotes around the member names.
   bezier_JSON = bezier_JSON.replace( /\'/g, "\"" );
   
   /*
   window.alert( "dildoID=" + id + ",\n" +
		 "publicDildoHash=" + public_hash + ",\n" +
		 "bend=" + bend + ",\n" +
		 "bezier_path=" + bezier_JSON
		 );
   */

   // Parse JSON string to object
   var bezierPath = IKRS.BezierPath.fromJSON( bezier_JSON.trim() );
   
   // Now convert to integer point representation
   var ibdata = bezierPath.toReducedListRepresentation();
   //window.alert( ibdata );

   window.open( "../?bend=" + bend + "&dildoID=" + id + "&publicDildoHash=" + public_hash + "&rbdata=" + ibdata );
 }
</script>

</head>

<body>

<!-- PLACEHOLDER for Google Adverts -->


<h1>Dildo-Generator - Gallery</h1>
<a href="../">Back to the dildo generator</a><br/>
<br/>
<?php

/**
 * This server script displays the gallery (the collection of stored dildo designs, which
 * reside in the database).
 *
 * @author  Ikaros Kappler
 * @date    2014-07-17
 * @version 1.0.0
 **/



// How many rows and columns should the gallery have?
$columnCount = 5;
$rowCount    = 3;


// Fetch gallery start offset and display length (both optional)
$startOffset   = FALSE;
$displayLength = FALSE;

if( array_key_exists("start_offset",$_GET) )
  $startOffset = $_GET["start_offset"];
if( array_key_exists("display_length",$_GET) )
  $displayLength = $_GET["display_length"];


if( !$startOffset || !is_numeric($startOffset) || $startOffset < 0 )
  $startOffset   = 0;
if( !$displayLength || !is_numeric($displayLength) || $display_length < 0 )
  $displayLength = $columnCount*$rowCount;



// Establish a database connection
require_once( "../inc/function.mcon.inc.php" );
$mcon = mcon();


$public_hash = FALSE;
if( array_key_exists("public_hash",$_GET) )
  $public_hash = $_GET["public_hash"];



if( $public_hash )
  echo "<a href=\"?\">&larr; to the gallery</a><br/>\n";


$condition = "disabled_by_moderator = 'N' ";


// First: count all entries:
$query =
  "SELECT count(id) AS _num_total_rows FROM custom_dildos WHERE " . $condition . ";";
$result = mysql_query($query,$mcon);
if( !$result ) {
  echo "<div class=\"error\">Error: failed to count rows: " . mysql_error($mcon) . "</div>\n";
  mysql_close( $mcon );
  die();
}
$row = mysql_fetch_assoc($result);
mysql_free_result($result);
$num_total_rows = $row["_num_total_rows"];




// Now start the real (limited!) query
$query =
  "SELECT * " .
  "FROM custom_dildos " .
  "WHERE disabled_by_moderator = 'N' ";

if( $public_hash )
  $query .= 
    "AND public_hash = '" . addslashes($public_hash) . "' ";

$query .=
  "ORDER BY id DESC " .
  "LIMIT " . addslashes($startOffset) . ", " . addslashes($displayLength) . ";";

$result = mysql_query( $query, $mcon );
if( !$result ) {

  echo "<div class=\"error\">Failed to query stored dildos: " . mysql_error($mcon) . ".</div>\n";

} else {

  $navigationHTML = FALSE;

  if( !$public_hash ) {
    require_once( "../inc/function.generate_result_set_navigator.inc.php" );
    list( $rc,
	  $errmsg,
	  $navigationHTML ) = generate_result_set_navigator( $result,
							   
							     $startOffset,
							     $displayLength,
							   
							     $num_total_rows,
							     3,                       // interval_radius
							     "rs_nav"
							     );
    $navigationHTML = "<div style=\"color: #888888; font-weight: bold;\">" . $navigationHTML . "</div>\n";
							 


    // Here starts th real output of the data.
    echo $navigationHTML;
  }


  $i           = 0;
  echo "<table border=\"0\">\n";
  while( $row = mysql_fetch_assoc($result) ) {
    
    if( $public_hash && $i == 0 ) {
      
      echo "   <tr>\n";
      echo "      <td colspan=\"2\" align=\"center\">";
      if( $row["allow_download"] == "Y" )
	echo "The maker of this dong model wants you to download or edit this precious thingy: <button onclick=\"loadDildo('" . $row["id"] . "','" . $row["public_hash"] . "','" . $row["bend"] . "', '" . str_replace(array("'","\""), array("\\'","\\'"),$row["bezier_path"]) . "');\">Load &#8663;</button>";
      //else
      //	echo "Unfortunately the creator of this dong model does not allow to download the mesh.";
      echo "</td>\n";
      echo "   </tr>\n";

    }

    if( $i % $columnCount == 0 ) {
      if( $i > 0 )
	echo "</tr>\n";
      echo "   <tr>\n";
    }
    
    echo 
      "      <td class=\"gallery\">\n";
    
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
      "         <b>" . str_replace( array("<",">","&"), array("&lt;","&gt;","&amp;"), $row["name"] ) . "</b><br/>\n".
      "         by " . str_replace( array("<",">","&"), array("&lt;","&gt;","&amp;"), $row["user_name"] ) . "<br/>\n";
    if( $public_hash ) {
      echo "         " . date("Y-m-d", $row["date_created"]) . "<br/>\n";
      
      if( $row["hide_email_address"] != 'Y' )
	echo "         Email: " . str_replace( array("<",">","&"), array("&lt;","&gt;","&amp;"), $row["email_address"] ) . "<br/>\n";

      // Include the social media bar
      echo "<div style=\"text-align: center\">\n";
      include( "../inc/print_two_click_plugin.inc.php" );
      echo "</div>\n";
    }

    echo
      "      </td>\n";


    // Also display bezier image?
    if( $public_hash ) {
      echo "      <td class=\"gallery\"><img src=\"getBezierImage.php?public_hash=" . $row["public_hash"] . "\" width=\"512\" height=\"768\" alt=\"dildo bezier preview #" . $row["id"] . "\" /></td>\n";
    }
    
    
    $i++;
    
  } // END while [print table data]
  mysql_free_result( $result );

  echo "</table>\n";


  if( !$public_hash ) {
    echo $navigationHTML;
  }

} // END else




if( $public_hash )
  echo "<a href=\"?\">&larr; to the gallery</a><br/>\n";


mysql_close( $mcon );


?>

<br/>

<!-- PLACEHOLDER for Piwik -->

<!-- PLACEHOLDER for Google Adverts -->


</body>
</html>