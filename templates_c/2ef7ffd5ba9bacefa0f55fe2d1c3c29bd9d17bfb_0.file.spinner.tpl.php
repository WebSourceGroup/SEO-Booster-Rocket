<?php
/* Smarty version 3.1.31-dev/6, created on 2017-12-13 08:04:49
  from "/var/www/usayo.ga/wp-content/plugins/usayoga/templates/spinner.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31-dev/6',
  'unifunc' => 'content_5a30df21e64299_79803260',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2ef7ffd5ba9bacefa0f55fe2d1c3c29bd9d17bfb' => 
    array (
      0 => '/var/www/usayo.ga/wp-content/plugins/usayoga/templates/spinner.tpl',
      1 => 1513142108,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a30df21e64299_79803260 (Smarty_Internal_Template $_smarty_tpl) {
?>
<style>
.spinner {
  height: 60px;
  width: 60px;
  margin: 94px auto 0 auto;
  position: relative;
  -webkit-animation: rotation .6s infinite linear;
  -moz-animation: rotation .6s infinite linear;
  -o-animation: rotation .6s infinite linear;
  animation: rotation .6s infinite linear;
  border-left: 6px solid rgba(0, 174, 239, .15);
  border-right: 6px solid rgba(0, 174, 239, .15);
  border-bottom: 6px solid rgba(0, 174, 239, .15);
  border-top: 6px solid rgba(0, 174, 239, .8);
  border-radius: 100%;
}

@-webkit-keyframes rotation {
  from {
    -webkit-transform: rotate(0deg);
  }
  to {
    -webkit-transform: rotate(359deg);
  }
}

@-moz-keyframes rotation {
  from {
    -moz-transform: rotate(0deg);
  }
  to {
    -moz-transform: rotate(359deg);
  }
}

@-o-keyframes rotation {
  from {
    -o-transform: rotate(0deg);
  }
  to {
    -o-transform: rotate(359deg);
  }
}

@keyframes rotation {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(359deg);
  }
}
</style>

<?php }
}
