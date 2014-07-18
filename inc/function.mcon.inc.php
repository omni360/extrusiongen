<?php

/**
 * @author  Ikaros Kappler
 * @date    2014-07-17
 * @version 1.0.0
 **/

function mcon() {
  // Establish a database connection
  $mcon        = mysql_connect( "127.0.0.1",        // MySQL host
				"dildogenerator",   // user
				"dildogenerator"    // password
				);
  mysql_select_db( "dildogenerator" );
  return $mcon;
}

?>