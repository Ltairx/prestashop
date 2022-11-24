<?php
/* Smarty version 3.1.43, created on 2022-11-22 13:12:16
  from '/var/www/html/prestashop/admin990d5icld/themes/default/template/content.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_637cbca0b0eaf6_11419481',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6724c76a67949e0cc0ab4508345773b120c99fbf' => 
    array (
      0 => '/var/www/html/prestashop/admin990d5icld/themes/default/template/content.tpl',
      1 => 1658334665,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_637cbca0b0eaf6_11419481 (Smarty_Internal_Template $_smarty_tpl) {
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
