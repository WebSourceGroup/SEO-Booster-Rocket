<?php
/* Smarty version 3.1.31-dev/6, created on 2017-12-15 20:04:49
  from "/var/www/usayo.ga/wp-content/plugins/usayoga/templates/htmlify.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31-dev/6',
  'unifunc' => 'content_5a342ae18301b8_58298505',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f66a20807e12ed66c7c2cc66729addabff90bb4c' => 
    array (
      0 => '/var/www/usayo.ga/wp-content/plugins/usayoga/templates/htmlify.tpl',
      1 => 1513368279,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a342ae18301b8_58298505 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_replace')) require_once '/var/www/usayo.ga/wp-content/plugins/usayoga/smarty/libs/plugins/modifier.replace.php';
?>
<br />
<h3 style="text-align: center;">Search for Yoga Studios by <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</h3>
<div class="div_table">
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['results']->value, 'result', false, NULL, 'result_list', array (
  'index' => true,
  'last' => true,
  'iteration' => true,
  'total' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['result']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_result_list']->value['iteration']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_result_list']->value['index']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_result_list']->value['last'] = $_smarty_tpl->tpl_vars['__smarty_foreach_result_list']->value['iteration'] == $_smarty_tpl->tpl_vars['__smarty_foreach_result_list']->value['total'];
?>
	<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_result_list']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_result_list']->value['index'] : null)%$_smarty_tpl->tpl_vars['mod']->value == 0) {?>
		<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_result_list']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_result_list']->value['index'] : null) != 0) {?>
			</div>
		<?php }?>
		<div class="div_row">
	<?php }?>
	<div class="div_cell"><a href="<?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['result']->value['url']," ","+");?>
"><?php echo $_smarty_tpl->tpl_vars['result']->value['name'];?>
</a></div>
	<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_result_list']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_result_list']->value['last'] : null)) {?>
		</div>
	<?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

</div>

<style>
.div_table {
	display: table;
	border: 1px solid;
	border-radius: 5px;
	width: 100%;
}
.div_row {
	display: table-row;
	border: 1px solid;
}
.div_cell {
	display: table-cell;
	padding: 3px;
	border: 1px solid;
	text-align: center;
}
</style>
<?php }
}
