<?php
/**
 * It does exactly what the name sais.
 *
 * @author  Ikaros Kappler
 * @date    2014-10-27
 * @version 1.0.0
 **/


function store_base64_encoded_image_in_filesystem( $filepath,
						   $base64_data
						   //$b64_offset = FALSE,
						   //$b64_length = FALSE
						   ) {

  /*
  if( $b64_offset === FALSE )
    $b64_offset = 0;
  if( $b64_length === FALSE )
    $b64_length = strlen($base64_data);


  $data_raw = $base64_data;
  */
  
  // Cut off anything?
  //if( $b64_offset != 0 || $b64_length != strlen($base4_data) )
    

    
  // Cut off the 'data:image/png;base64,' part to get the pure base64 data
  //$base64_raw = substr( $data_base64, 22 );
  //echo $base64_raw;
    
    
  //header( "Content-Type: image/png" );
    
  try {
    $fh = fopen( $filepath, "w" );
    fputs( $fh,
	   base64_decode( $base64_data,
			  false //true         // strict (will cause error if not base64)
			  )	 
	   );
    fclose( $fh );
    return array( 0,     // status: no error
		  FALSE 
		  );
  } catch( Exception $e ) {
    return array( 1,  // status
		  $e  // error
		  );
  }
  

}
						   


?>