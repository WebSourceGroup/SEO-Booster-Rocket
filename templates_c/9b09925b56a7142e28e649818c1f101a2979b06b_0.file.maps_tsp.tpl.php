<?php
/* Smarty version 3.1.31-dev/6, created on 2017-12-13 08:07:02
  from "/var/www/usayo.ga/wp-content/plugins/usayoga/templates/maps_tsp.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31-dev/6',
  'unifunc' => 'content_5a30dfa69063b0_80616254',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9b09925b56a7142e28e649818c1f101a2979b06b' => 
    array (
      0 => '/var/www/usayo.ga/wp-content/plugins/usayoga/templates/maps_tsp.tpl',
      1 => 1513142108,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a30dfa69063b0_80616254 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php echo '<script'; ?>
 src="./Maps-TSP/BpTspSolver.js"><?php echo '</script'; ?>
>

<div id="maps_tsp"></div>
<?php echo '<script'; ?>
>

var directionsPanel = document.getElementById("maps_tsp");
var tsp = new BpTspSolver(map, directionsPanel);

function showProgressdialog(){
  
  $("#progressbar").progressbar({value:15});
  
  $("#progressbarDialog").dialog({
    bgiframe: true,
    autoOpen: true,
    resizable: false,
    closeOnEscape: false,
    open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); },
    modal: true,
    position: 'center',
    // ['left','bottom'] // [100,100]
    height: 160,
    width: 420,
   /* minHeight: 200,
    minWidth: 300,
    maxHeight: 600,
    maxWidth: 800,*/
    dialogClass: 'gct_dialog',
    title: 'calculating routes - please wait',
   // show: 'drop',
    // blind, drop, scale
    zIndex: 2000,
    buttons:{
        'Close': {
            text: 'Cancel',
            disabled: false,
            click: function() {
              tsp.abort();
              $(this).dialog('close');
            }
        }
     }
});

}

    function addWaypointCallback() {
//	alert('addWaypointCallback()');
    }

    var onSolveCallback = function(tsp){	
      if(tsp.isAborted() !== true){
       	var dirRes = tsp.getGDirections();
       	
       	if(window.dirRender !== undefined){
          dirRender.setMap(null);    	
       	}
  			dirRender = new google.maps.DirectionsRenderer({
  				directions: dirRes,
  				hideRouteList: true,
  				map: map,
  				panel: null,
  				preserveViewport: false,
  				suppressInfoWindows: true,
  				suppressMarkers: true });
  	  } 
		};  

    function onSolveCallback() {
	alert('onSolveCallback');
	var order = tsp.getOrder();
	var durations = tsp.getDurations();
    }

tsp.setAvoidHighways(true);
tsp.setTravelMode(google.maps.DirectionsTravelMode.WALKING);
        {foreach from=$results item=result}
		{if isset($result['geometry']['location']['lat']) && $result['geometry']['location']['lat'] > 0 && isset($result['geometry']['location']['lng'])}
			var latLng = new google.maps.LatLng(<?php echo $_smarty_tpl->tpl_vars['result']->value['geometry']['location']['lat'];?>
,<?php echo $_smarty_tpl->tpl_vars['result']->value['geometry']['location']['lng'];?>
);
			tsp.addWaypoint(latLng, addWaypointCallback);
		{/if}
	{/foreach}

tsp.setOnProgressCallback(onProgressCallback);
showProgressdialog();
tsp.solveRoundTrip(onSolveCallback);

<?php echo '</script'; ?>
>

<?php }
}
