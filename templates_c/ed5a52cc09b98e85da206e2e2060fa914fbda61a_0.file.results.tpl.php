<?php
/* Smarty version 3.1.31-dev/6, created on 2017-12-13 08:22:05
  from "/var/www/usayo.ga/wp-content/plugins/usayoga/templates/results.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31-dev/6',
  'unifunc' => 'content_5a30e32d949246_68087459',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ed5a52cc09b98e85da206e2e2060fa914fbda61a' => 
    array (
      0 => '/var/www/usayo.ga/wp-content/plugins/usayoga/templates/results.tpl',
      1 => 1513152512,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./search.tpl' => 1,
    'file:./maps.tpl' => 1,
    'file:./maps_tsp.tpl' => 1,
  ),
),false)) {
function content_5a30e32d949246_68087459 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_replace')) require_once '/var/www/usayo.ga/wp-content/plugins/usayoga/smarty/libs/plugins/modifier.replace.php';
if (!is_callable('smarty_modifier_capitalize')) require_once '/var/www/usayo.ga/wp-content/plugins/usayoga/smarty/libs/plugins/modifier.capitalize.php';
?>
<div id="container" style="display: table; width: 100%">
  <div id="row" style="display: table-row; width: 100%">
   <div id="left" style="display: table-cell; width: 15%;">
    <?php $_smarty_tpl->_subTemplateRender("file:./search.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <h5 id="notice">You have Searched: <?php echo $_smarty_tpl->tpl_vars['search_term']->value;?>
</h5>
    <h5 id="notice">Number of Results: <?php echo count($_smarty_tpl->tpl_vars['results']->value);?>
</h5>
    <h5 id="notice">Web Service Request Count: <?php echo $_smarty_tpl->tpl_vars['request_count']->value;?>
</h5>
    <div id="notice">
	<a href="#results">Take me to the Results!</a>
    </div>
   </div>
   <div id="right" style="display: table-cell; width: 80%;">
	<h5>Map of Results</h5>
	<?php $_smarty_tpl->_subTemplateRender("file:./maps.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
	
	<?php $_smarty_tpl->_subTemplateRender("file:./maps_tsp.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

   </div>
  </div>
</div>
<br />
	<a name="results"></a>
	<table >
	<tr>
		<th>#</th>
		<th>Icon</th>
		<th>Map</th>
		<th>Open?</th>
		<th>Name</th>
		<th>Address</th>
		<th>Photos/Contact Names?</th>
	</tr>
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['results']->value, 'result', false, 'count');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['count']->value => $_smarty_tpl->tpl_vars['result']->value) {
?>
	<?php if (isset($_smarty_tpl->tpl_vars['result']->value['name'])) {?>
	<tr>
		<td><a name="<?php echo $_smarty_tpl->tpl_vars['result']->value['id'];?>
"></a><?php echo $_smarty_tpl->tpl_vars['count']->value;?>
</td>
		<td><img src="<?php echo $_smarty_tpl->tpl_vars['result']->value['icon'];?>
" width="20px" height="20px" title="<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['result']->value['types'], 'types');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['types']->value) {
echo smarty_modifier_capitalize(smarty_modifier_replace($_smarty_tpl->tpl_vars['types']->value,"_"," "),true);?>
, <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
"></td>
		<td><a target="_blank" href="http://maps.google.com/?q=<?php echo $_smarty_tpl->tpl_vars['result']->value['name'];?>
, <?php echo $_smarty_tpl->tpl_vars['result']->value['formatted_address'];?>
">Link</a></td>
		<td>
		<?php if (isset($_smarty_tpl->tpl_vars['result']->value['opening_hours'])) {?>
			<?php ob_start();
echo $_smarty_tpl->tpl_vars['result']->value['opening_hours']['open_now'];
$_prefixVariable1=ob_get_clean();
if ($_prefixVariable1 == 1) {?>Yes<?php } else {
ob_start();
echo $_smarty_tpl->tpl_vars['result']->value['opening_hours']['open_now'];
$_prefixVariable2=ob_get_clean();
if ($_prefixVariable2 == 0) {?>No<?php }}?>
		<?php }?>
			</td>
		<td><?php echo $_smarty_tpl->tpl_vars['result']->value['name'];?>
</td>
		<td><?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['result']->value['formatted_address'],", United States",'');?>
</td>
		<td><?php if (isset($_smarty_tpl->tpl_vars['result']->value['photos'])) {
echo smarty_modifier_replace($_smarty_tpl->tpl_vars['result']->value['photos'][0]['html_attributions'][0],"<a href=","<a target='_blank' href=");
}?></td>
	</tr>
	<?php }?>

<?php
}
} else {
?>

	<tr><td>No Results were Found. Please Try Again</td></tr>
<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

</table>
<?php }
}
