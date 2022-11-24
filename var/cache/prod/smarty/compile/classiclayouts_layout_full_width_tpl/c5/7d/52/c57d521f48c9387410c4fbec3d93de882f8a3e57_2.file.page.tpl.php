<?php
/* Smarty version 3.1.43, created on 2022-11-22 17:33:12
  from '/var/www/html/prestashop/themes/classic/templates/page.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_637cf9c883a7e5_56815206',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c57d521f48c9387410c4fbec3d93de882f8a3e57' => 
    array (
      0 => '/var/www/html/prestashop/themes/classic/templates/page.tpl',
      1 => 1658334665,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_637cf9c883a7e5_56815206 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1524497930637cf9c8831b12_21690218', 'content');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, $_smarty_tpl->tpl_vars['layout']->value);
}
/* {block 'page_title'} */
class Block_1544437121637cf9c8832a62_36686864 extends Smarty_Internal_Block
{
public $callsChild = 'true';
public $hide = 'true';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <header class="page-header">
          <h1><?php 
$_smarty_tpl->inheritance->callChild($_smarty_tpl, $this);
?>
</h1>
        </header>
      <?php
}
}
/* {/block 'page_title'} */
/* {block 'page_header_container'} */
class Block_2050067869637cf9c88321e6_42195281 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1544437121637cf9c8832a62_36686864', 'page_title', $this->tplIndex);
?>

    <?php
}
}
/* {/block 'page_header_container'} */
/* {block 'page_content_top'} */
class Block_1779016041637cf9c8838356_44065041 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'page_content_top'} */
/* {block 'page_content'} */
class Block_745627058637cf9c8838ac4_00191038 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <!-- Page content -->
        <?php
}
}
/* {/block 'page_content'} */
/* {block 'page_content_container'} */
class Block_479895578637cf9c8837dd3_86203940 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <div id="content" class="page-content card card-block">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1779016041637cf9c8838356_44065041', 'page_content_top', $this->tplIndex);
?>

        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_745627058637cf9c8838ac4_00191038', 'page_content', $this->tplIndex);
?>

      </div>
    <?php
}
}
/* {/block 'page_content_container'} */
/* {block 'page_footer'} */
class Block_42461286637cf9c8839a64_79088955 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <!-- Footer content -->
        <?php
}
}
/* {/block 'page_footer'} */
/* {block 'page_footer_container'} */
class Block_8404125637cf9c88395a4_06728543 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <footer class="page-footer">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_42461286637cf9c8839a64_79088955', 'page_footer', $this->tplIndex);
?>

      </footer>
    <?php
}
}
/* {/block 'page_footer_container'} */
/* {block 'content'} */
class Block_1524497930637cf9c8831b12_21690218 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_1524497930637cf9c8831b12_21690218',
  ),
  'page_header_container' => 
  array (
    0 => 'Block_2050067869637cf9c88321e6_42195281',
  ),
  'page_title' => 
  array (
    0 => 'Block_1544437121637cf9c8832a62_36686864',
  ),
  'page_content_container' => 
  array (
    0 => 'Block_479895578637cf9c8837dd3_86203940',
  ),
  'page_content_top' => 
  array (
    0 => 'Block_1779016041637cf9c8838356_44065041',
  ),
  'page_content' => 
  array (
    0 => 'Block_745627058637cf9c8838ac4_00191038',
  ),
  'page_footer_container' => 
  array (
    0 => 'Block_8404125637cf9c88395a4_06728543',
  ),
  'page_footer' => 
  array (
    0 => 'Block_42461286637cf9c8839a64_79088955',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


  <section id="main">

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2050067869637cf9c88321e6_42195281', 'page_header_container', $this->tplIndex);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_479895578637cf9c8837dd3_86203940', 'page_content_container', $this->tplIndex);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8404125637cf9c88395a4_06728543', 'page_footer_container', $this->tplIndex);
?>


  </section>

<?php
}
}
/* {/block 'content'} */
}
