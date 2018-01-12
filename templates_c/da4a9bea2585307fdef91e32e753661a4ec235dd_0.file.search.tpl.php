<?php
/* Smarty version 3.1.31-dev/6, created on 2017-12-15 08:07:12
  from "/var/www/usayo.ga/wp-content/plugins/usayoga/templates/search.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31-dev/6',
  'unifunc' => 'content_5a3382b058dda6_75892785',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'da4a9bea2585307fdef91e32e753661a4ec235dd' => 
    array (
      0 => '/var/www/usayo.ga/wp-content/plugins/usayoga/templates/search.tpl',
      1 => 1513325228,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./spinner.tpl' => 1,
  ),
),false)) {
function content_5a3382b058dda6_75892785 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="spinner" id="spinner"></div>
<div id="searchform">
	<h4>Search for a Yoga Studio</h4>
	<form method="GET" action="/search-for-a-yoga-studio/" onSubmit="document.getElementById('spinner').style.display = 'block'">
	<input type="text" placeholder="Enter Town" name="town" id="yui-input-town" value="<?php if (isset($_smarty_tpl->tpl_vars['town']->value)) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['town']->value, ENT_QUOTES, 'UTF-8', true);
}?>"><br />
	<input type="text" placeholder="Enter State" name="state" id='yui-input-state' maxlength="30" value="<?php if (isset($_smarty_tpl->tpl_vars['state']->value)) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['state']->value, ENT_QUOTES, 'UTF-8', true);
}?>"><br />
	<input type="submit" value="SEARCH">
	</form>
</div>

<?php $_smarty_tpl->_subTemplateRender("file:./spinner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }
}
