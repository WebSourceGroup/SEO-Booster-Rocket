<?php
/* Smarty version 3.1.31-dev/6, created on 2017-12-13 09:11:03
  from "/var/www/usayo.ga/wp-content/plugins/usayoga/templates/css.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31-dev/6',
  'unifunc' => 'content_5a30eea7a8c073_96803328',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1929b97ae09d89608a94a502e34c9e70956d83e4' => 
    array (
      0 => '/var/www/usayo.ga/wp-content/plugins/usayoga/templates/css.tpl',
      1 => 1513156262,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./yui.tpl' => 1,
  ),
),false)) {
function content_5a30eea7a8c073_96803328 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:./yui.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }

        table th { border-bottom: 1px solid #000; }
        table td { margin: 3px; border: 1px solid #fff; }

        #legend, #notice, #right, #searchform {
    border-radius: 10px;
    background: #f0f0f0;
    padding: 5px;
    margin: 5px;
    width: 225px;
        }
	#searchform input {
		border-radius: 5px;
		border-style: solid;
		width: 100%;
		border-width: 1px;
	}
	#searchform p, #right h5, #searchform h5 { margin: 5px; padding: 5px; }

	#spinner {
    display: none; position: absolute; top: 20px; left: 100px;
	}
</style>
<?php }
}
