<?php
/**
 * @author  Ikaros Kappler
 * @date    2014-07-24
 * @version 1.0.0
 **/


function generate_result_set_navigator( $result,
					 
					$startOffset,
					$displayLength,
					
					$num_total_rows,
					$interval_radius = 3,
					
					$href_class_name = "rs_nav"
					) {


  
  if( !$startOffset || !is_numeric($startOffset) || $startOffset < 0 )
    $startOffset   = 0;
  if( !$displayLength || !is_numeric($displayLength) || $display_length < 0 )
    $displayLength = 20;
  if( $interval_radius || !is_numeric($interval_radius) || $interval_radius < 0 )
    $interval_radius = 3;


  
  // Generate navigation
  $num_rows           = mysql_num_rows( $result );
  $num_pages          = ceil( $num_total_rows / $displayLength );
  $current_page       = ceil( $startOffset    / $displayLength );
  //$interval_radius    = 3;

  // Determine if there is enough page space backwards and/or forwards
  $display_start_page = max( 0,            $current_page-$interval_radius );
  $display_end_page   = min( $num_pages-1, $current_page+$interval_radius );
  // Re-check range (might be at lower or/and upper bounds)
  if( $display_end_page-$display_start_page < $interval_radius*2+1 ) {
    //if( $num_pages >= $interval_radius*2+1 ) {
      if( $current_page-$display_start_page < $interval_radius )
	$display_end_page += $interval_radius-($current_page - $display_start_page);
      else if( $display_end_page-$current_page < $interval_radius )
	$display_start_page -= $interval_radius-($display_end_page - $current_page );

      
      //}
      $display_start_page = max( 0,            $display_start_page );
      $display_end_page   = min( $num_pages-1, $display_end_page );
  }
  
  

  // echo "num_rows=" . $num_rows . ", num_pages=" . $num_pages . ", current_page=" . $current_page . ", num_pages=" . $num_pages . ", display_start_page=" . $display_start_page . ", display_end_page=" . $display_end_page . "<br/>\n";
  // BEGIN navi
  $navi       = ""; //"<div style=\"font-family: Arial;\">";


  // Make Jump-to-Begin link
  if( $current_page > 0 )
    $navi .= "<a href=\"?start_offset=0&display_length=" . $displayLength . "\" class=\"" . $href_class_name . "\">&laquo;</a>\n";
  else
    $navi .= "&laquo;\n";


  // Make Jump-to-Previous-Page link
  if( $current_page > 0 )
    $navi .= "<a href=\"?start_offset=" . (($current_page-1)*$displayLength) . "&display_length=" . $displayLength . "\" class=\"" . $href_class_name . "\">&lsaquo;</a>\n";
  else
    $navi .= "&lsaquo;\n";


  // Make numbers inside (three minus and three plus around current page)
  //for( $p = max(0,$current_page-$interval_radius); $p <= min($num_pages-1,$current_page+$interval_radius); $p++ ) {
  for( $p = $display_start_page; $p <= $display_end_page; $p++ ) {
    if( $p == $current_page )
      $navi .= "[" . $p . "]\n";
    else
      $navi .= "<a href=\"?start_offset=" . ($p * $displayLength) . "&display_length=" . $displayLength . "\" class=\"" . $href_class_name . "\">[" . $p . "]</a>\n";
  }

  
  // Make Jump-to-Next-Page link
  if( $current_page+1 < $num_pages )
    $navi .= "<a href=\"?start_offset=" . (($current_page+1)*$displayLength) . "&display_length=" . $displayLength . "\" class=\"" . $href_class_name . "\">&rsaquo;</a>\n";
  else
    $navi .= "&rsaquo;\n";


  // Make Jump-to-End link
  if( $current_page+1 < $num_pages )
    $navi .= "<a href=\"?start_offset=" . (($num_pages-1)*$displayLength) . "&display_length=" . $displayLength . "\" class=\"" . $href_class_name . "\">&raquo;</a>\n";
  else
    $navi .= "&raquo;\n";


  // END navi
  //$navi       .= "</div>\n";
  
  return array( 0,     // rc=0 indicates success
		FALSE, // No error
		$navi
		);


} // END function



?>