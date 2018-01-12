<?php
/* Smarty version 3.1.31-dev/6, created on 2017-12-15 08:32:13
  from "/var/www/usayo.ga/wp-content/plugins/usayoga/templates/results.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31-dev/6',
  'unifunc' => 'content_5a33888d5c9943_75800489',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c3b85d52db4cff4939f4723e9878474d6f519c4c' => 
    array (
      0 => '/var/www/usayo.ga/wp-content/plugins/usayoga/templates/results.tpl',
      1 => 1513326696,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./search.tpl' => 1,
    'file:./maps.tpl' => 1,
  ),
),false)) {
function content_5a33888d5c9943_75800489 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_replace')) require_once '/var/www/usayo.ga/wp-content/plugins/usayoga/smarty/libs/plugins/modifier.replace.php';
?>
<div id="container" style="display: table; width: 100%">
  <div id="row" style="display: table-row; width: 100%">
   <div id="left" style="display: table-cell; width: 15%;">
    <?php $_smarty_tpl->_subTemplateRender("file:./search.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <h5 id="notice">Number of Results: <?php echo count($_smarty_tpl->tpl_vars['results']->value);?>
</h5>
    <div id="notice">
	<a href="#results">Take me to the Results!</a>
    </div>
   </div>
   <div id="right" style="display: table-cell; width: 80%;">
	<h5>Map of Results</h5>
	<?php $_smarty_tpl->_subTemplateRender("file:./maps.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
	
   </div>
  </div>
</div>
<br />
	<a name="results"></a>
	<table>
	<tr style="font-size: 75%;">
		<th>Name</th>
		<th>Address</th>
		<th>Rating</th>
		<th>Open Now?</th>
		<th>Photos/Contact Names?</th>
	</tr>
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['results']->value, 'result', false, 'count');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['count']->value => $_smarty_tpl->tpl_vars['result']->value) {
?>
	<?php if (isset($_smarty_tpl->tpl_vars['result']->value['name'])) {?>
	<tr>
		<td><?php echo $_smarty_tpl->tpl_vars['result']->value['name'];?>
</td>
		<td><?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['result']->value['formatted_address'],", United States",'');?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['result']->value['rating'];?>
</td>
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
		<td><?php if (isset($_smarty_tpl->tpl_vars['result']->value['photos'])) {
echo smarty_modifier_replace($_smarty_tpl->tpl_vars['result']->value['photos'][0]['html_attributions'][0],"<a href=","<a target='_blank' href=");
}?></td>
	</tr>
	<?php }
}
} else {
?>

	<h5>No Results were Found. Please Try Again</h5>
<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

</table>
<?php }
}
