<?php
/**
 * This file contains the configuration for basic php script
 * settings (mostly for the gallery).
 *
 * @author  Ikaros Kappler
 * @date    2014-10-27
 * @version 1.0.0
 **/


$_DILDO_CONFIG = array();

$_DILDO_CONFIG[ "gallery_settings" ] = array( "STORE_PREVIEW_IMAGES_IN_FILESYSTEM" => TRUE,
					      "STORE_BEZIER_IMAGES_IN_FILESYSTEM"  => TRUE,
					      
					      // !!! Settings this to TRUE still needs to be tested !!!
					      "DILDO_UPDATE_ALLOWED"               => FALSE,
					      
					      "ALLOWED_SERVER_NAMES"               => array( "www.dildo-generator.com",
											     "dildo-generator.com"
											     )
					     );




?>