/**
 * This is a global config file that helps to configure basic settings for the
 * dildo generator.
 *
 * It should help the guys from wamungo.com to customize the dildo generator in 
 * a comfortable manner.
 *
 *
 * @author   Ikaros Kappler
 * @date     2014-06-10
 * @modified 2014-06-19 Ikaros Kappler (added the canvas background image settings).
 * @version  1.0.0
 **/


if( !_DILDO_CONFIG || typeof _DILDO_CONFIG === "undefined" )
    var _DILDO_CONFIG = {};

if( !_DILDO_CONFIG.IMAGES || typeof _DILDO_CONFIG.IMAGES === "undefined" )
    _DILDO_CONFIG.IMAGES = {};



/**
 * Set this flag to true if you wish the Model->Export sub menu to be hidden.
 * Valid values: true|false
 **/
_DILDO_CONFIG.HIDE_EXPORT_MESH_MENU       = false;  
//_DILDO_CONFIG.HIDE_EXPORT_MESH_MENU       = true; 



/**
 * Set this flag to true if you wish the whole Print menu to be hidden.
 * Valid values: true|false
 **/
//_DILDO_CONFIG.HIDE_PRINT_MENU             = false; // true|false
_DILDO_CONFIG.HIDE_PRINT_MENU             = !isDildoGeneratorDomain(); 

/**
 * Set the Print->Order_Print sub menu action to the specific javascript action (string).
 *
 * This only takes effect if the _DILDO_CONFIG.HIDE_PRINT_MENU is set to false.
 **/
//_DILDO_CONFIG.ORDER_PRINT_ACTION          = "_order_send_to_server('store_custom_dildo.php?bend=%bend%&bezier_path=%bezier_path%&id=%id%');";
_DILDO_CONFIG.ORDER_PRINT_ACTION          = "order_print();";



/**
 * Defines the bezier canvas background image to be drawn (string: url).
 **/
_DILDO_CONFIG.IMAGES.BEZIER_BACKGROUND    = "img/bg_bezier.png";



/**
 * Defines the preview canvas background image to be drawn (string: url).
 **/
_DILDO_CONFIG.IMAGES.PREVIEW_BACKGROUND   = "img/bg_preview.png";

