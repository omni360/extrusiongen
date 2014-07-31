<?php

/**
 * This function if the passed sentence contains any unwanted
 * words.
 *
 * If the sentence is 'clean', the function returns TRUE.
 * Otherwise the function returns FALSE.
 *
 * @author  Ikaros Kappler
 * @date    2014-07-30
 * @version 1.0.0
 **/

function gallery_word_check( $sentence ) {
  
  $_ILLEGAL_WORDS = array( "nigger",
			   "n1gger",
			   "n1gg3r",
			   "nigg3r",
			   "jew",
			   "j3w"
			   );
  
  $sentence = strtolower( $sentence );
  foreach( $_ILLEGAL_WORDS AS $i => $w ) {
    
    if( strpos($word,$w) !== FALSE ) {
      return FALSE;
    }

  }


  return TRUE;
}

?>