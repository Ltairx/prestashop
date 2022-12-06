<?php
/* Smarty version 3.1.43, created on 2022-12-06 12:19:58
  from '/var/www/html/prestashop/admin990d5icld/themes/default/template/content.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_638f255e3a9018_45049435',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6724c76a67949e0cc0ab4508345773b120c99fbf' => 
    array (
      0 => '/var/www/html/prestashop/admin990d5icld/themes/default/template/content.tpl',
      1 => 1669913630,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_638f255e3a9018_45049435 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="ajax_confirmation" class="alert alert-success hide"></div>
<div id="ajaxBox" style="display:none"></div>

<div class="row">
	<div class="col-lg-12">
		<?php if ((isset($_smarty_tpl->tpl_vars['content']->value))) {?>
			<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

		<?php }?>
	</div>
</div>
<?php }
}
