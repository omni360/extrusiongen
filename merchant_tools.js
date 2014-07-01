/**
 * This is a customizable javascript collection for the merchants.
 *
 * Store here whatever you need.
 *
 *
 * @author  Ikaros Kappler
 * @date    2014-06-10
 * @version 1.0.0
 **/


/**
 * The url param may contain the %json_data% placeholder.
 *
 * It will be replace by a JSON object that describes the current settings for the
 * dildo generator.
 *
 **/
var seen = [];
function _order_send_to_server( url ) {

    // This is a mandatory size check.
    // Each printer has a max X-Y-sized printing bed. This function call
    // checks if the created mesh would be out of bounds and asks the user
    // if he/she would like to continue though (if too large).
    // If everything is fine (size OK, or user wants to continue) the 
    // function returns true.
    if( !checkSizeBeforeSaving() )
	return false;




    // This function returns a JSON object containing all essential
    // settings. See ZipFileImporter.js for details.
    // Actually all form settings a stored into a JSON object, thus
    // makes it possible to restore the settings the user made each
    // time it's needed (part of the save/load cycle).
    var json_object = ZipFileExporter._build_export_data(); 


    // Fetch the dildoID (if already saved before)
    var dildoID     = -1;
    if( document.getElementById("dildoID") )
	dildoID = document.getElementById("dildoID").value;

    var newURL    = url;
    newURL    = newURL.replace( new RegExp("%bezier_path%", 'g'), 
				json_object.bezierPath.toJSON()           
			      );
    newURL    = newURL.replace( new RegExp("%bend%", 'g'), 
				json_object.meshSettings.bendAngle        
			      );
    newURL    = newURL.replace( new RegExp("%id%", 'g'), 
				dildoID        
			      );
    


    // Now call the URL (might be a remote server)
    // This is the old version: a javascript Popup. Ugly :(
    /* 
    window.open( newURL, 
		 "store_custom_dildo",  // window name
		 "height=600,width=600" // Params
	       );
    */

    // This is the new version: an AJAX script that runs in background
    _asynchronousURLCall( newURL );

}

function _asynchronousURLCall( url ) {

    // The createXMLHttpRequest function is defined in the main.js file
    var request = createXMLHttpRequest();
    
    request.onreadystatechange = function () {
        if( request.readyState == 4 ) {
	    
	    // Everything OK. Model saved.
	    
	    // Fetch the ID.
	    var dildoID = request.responseText;
	    
	    // (Re-)Store the ID into the HTML form (for later updates)
	    messageBox.show( "<br/>\n" +
			     "Your settings have been saved.<br/>\n" +
			     "(dildoID=" + dildoID + ")<br/>\n" +
			     "<br/>\n" +
			     "<button onclick=\"messageBox.hide()\">OK</button>\n"
			   );
	    setStatus( "Your settings have been saved. (id=" + dildoID + ")" );
	    document.getElementById( "dildoID" ).value = dildoID;
	       
        } else {

	    // Error returned.
	    console.log( "XMLHttpRequest returned readyState=" + request.readyState + ": " + request.responseText );
	    setStatus( "Failed to save your settings!" );

	}
    };

    request.open( "GET", url, true );
    request.send( null ); // No POST data


}
