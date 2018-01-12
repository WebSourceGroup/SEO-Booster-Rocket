<?php
/* Smarty version 3.1.31-dev/6, created on 2017-12-13 21:51:19
  from "/var/www/usayo.ga/wp-content/plugins/usayoga/templates/maps.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31-dev/6',
  'unifunc' => 'content_5a31a0d7db06c4_38354461',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ac101870c71c6cab0998943f62fdd153090a99ee' => 
    array (
      0 => '/var/www/usayo.ga/wp-content/plugins/usayoga/templates/maps.tpl',
      1 => 1513201811,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a31a0d7db06c4_38354461 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div id="map" style="height: 600px;"></div>

<?php echo '<script'; ?>
>
var map;

function createMarker(name,lat,lng,id,result_icon) {
    var info_content = name+": <a href='#"+id+"'>Jump to</a>";
    var info_window = new google.maps.InfoWindow({ content: info_content });

    var marker = new google.maps.Marker({
      map: map,
      icon: {
        url: result_icon,
        anchor: new google.maps.Point(20, 20),
        scaledSize: new google.maps.Size(20, 20)
      },
      title: name,
      position: new google.maps.LatLng(lat,lng),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    marker.addListener('click', function() {
	info_window.open(map,marker);
    });
}


function initMap() {
	map = new google.maps.Map(document.getElementById('map'), {

	  center: {lat: <?php echo $_smarty_tpl->tpl_vars['geolocation']->value[0];?>
,lng: <?php echo $_smarty_tpl->tpl_vars['geolocation']->value[1];?>
},
          scrollwheel: false,
          zoom: 12
	});



	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['results']->value, 'result', false, NULL, 'foo', array (
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['result']->value) {
?>
		<?php if (isset($_smarty_tpl->tpl_vars['result']->value['place_id'])) {?>
    			createMarker('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
',<?php echo $_smarty_tpl->tpl_vars['result']->value['geometry']['location']['lat'];?>
,<?php echo $_smarty_tpl->tpl_vars['result']->value['geometry']['location']['lng'];?>
,'<?php echo $_smarty_tpl->tpl_vars['result']->value['id'];?>
','<?php echo $_smarty_tpl->tpl_vars['result']->value['icon'];?>
');
		<?php }?>
	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

}

<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCw1kFZLBNcOJjyeFUIbE4ywupSvw614k8&callback=initMap&libraries=places"><?php echo '</script'; ?>
>
<?php }
}
