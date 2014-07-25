/**
 * This is a plain file defining a single javasscript object for
 * the presets.
 *
 * The presets defined in the object specify the preset menu strucure.
 *
 *
 * Additionally there is a function for populating the menu structure
 * for the presets.
 *
 *
 * @author  Ikaros Kappler
 * @date    2014-06-19
 * @version 1.0.0
 **/


if( !_DILDO_PRESETS || typeof _DILDO_PRESETS === "undefined" )
    var _DILDO_PRESETS = {};


/**
 * Note that the bezier JSON member names need to be put into double quotes.
 **/
_DILDO_PRESETS.plugs = { label:    "Plugs",
			 elements: [

			     { name:        "bender",
			       label:       "Bender",
			       bezier_json: "[ { \"startPoint\" : [-82,121], \"endPoint\" : [-65.6632547130022,66.86253028822362], \"startControlPoint\": [-90,87], \"endControlPoint\" : [-65.1280116275288,79.81498568733232] }, { \"startPoint\" : [-65.6632547130022,66.86253028822362], \"endPoint\" : [-57.454814814814796,5.460592592592583], \"startControlPoint\": [-67.90083458315588,12.714883626940079], \"endControlPoint\" : [-66.28766869253815,34.77964111961321] }, { \"startPoint\" : [-57.454814814814796,5.460592592592583], \"endPoint\" : [-55,-139], \"startControlPoint\": [-50.31974300727449,-18.222977798698675], \"endControlPoint\" : [-84.38654635129569,-50.09980658609145] }, { \"startPoint\" : [-55,-139], \"endPoint\" : [-51.66118578883062,-227.750293953586], \"startControlPoint\": [-39.46858425198657,-185.98564599883105], \"endControlPoint\" : [-56.750583998055625,-189.07086756347596] }, { \"startPoint\" : [-51.66118578883062,-227.750293953586], \"endPoint\" : [-2,-323], \"startControlPoint\": [-46.66118578883062,-265.75029395358604], \"endControlPoint\" : [-34,-323] } ]",
			       bend_angle:  15
			     },

			     { name:        "simple",
			       label:       "Simple",
			       bezier_json: "[ { \"startPoint\" : [-122,77.80736634304651], \"endPoint\" : [-65.59022229786551,21.46778533702511], \"startControlPoint\": [-121.62058129515852,25.08908859418696], \"endControlPoint\" : [-79.33419353770395,48.71529293460728] }, { \"startPoint\" : [-65.59022229786551,21.46778533702511], \"endPoint\" : [-67.81202987758626,-127.8068053796891], \"startControlPoint\": [-52.448492057756646,-4.585775770903305], \"endControlPoint\" : [-118.74009448772384,-54.213019624416724] }, { \"startPoint\" : [-67.81202987758626,-127.8068053796891], \"endPoint\" : [-66.86203591980056,-242.40824513210237], \"startControlPoint\": [-36.55872162861639,-172.9695126026205], \"endControlPoint\" : [-84.09275729013092,-204.6502273221321] }, { \"startPoint\" : [-66.86203591980056,-242.40824513210237], \"endPoint\" : [-21.108966092052256,-323], \"startControlPoint\": [-50.901371329358476,-277.3831626014642], \"endControlPoint\" : [-53.05779349623559,-323] } ]",
			       bend_angle:  0
			     }

			 ]
		       };





function populate_dildo_presets_menu( presets ) {


    for( var category_name in presets ) {
	
	var category = presets[ category_name ];

	document.write( "<li><a href=\"#\" class=\"popout\">Presets &gt;</a>\n" );
	document.write( "<ul>\n" );
	
	for( var i in category.elements ) {

	    var preset      = category.elements[i];
	    document.write( "<li><a href=\"#\" onclick=\"setBezierPathFromJSON(_DILDO_PRESETS." + category_name + ".elements[" + i + "].bezier_json,_DILDO_PRESETS." + category_name + ".elements[" + i + "].bend_angle);\">" + preset.label + "</a></li>\n" );
	    
	}
	
	
	document.write( "</ul>\n" );
	document.write( "</li>\n" );

    }


}