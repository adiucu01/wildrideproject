<?php /* Smarty version Smarty-3.1.13, created on 2013-06-02 13:40:51
         compiled from "..\..\..\templates\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2973151aa0c5832c027-34047665%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '56a6e27c4102e1d4502abc03781d09cd03adacdd' => 
    array (
      0 => '..\\..\\..\\templates\\index.tpl',
      1 => 1370169195,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2973151aa0c5832c027-34047665',
  'function' => 
  array (
  ),
  'cache_lifetime' => 120,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51aa0c58760c26_53953744',
  'variables' => 
  array (
    'customer' => 0,
    'sender' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51aa0c58760c26_53953744')) {function content_51aa0c58760c26_53953744($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("test.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars("setup", 'local'); ?>
<?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array('title'=>'foo'), 0);?>


<header>
    <div class="content">
        <div id="logo">
            <a href="" alt=""><img src="../../../img/logo.png" alt=""/></a>
        </div>
        <div id="contact"> 
            <p> Luni-Vineri: 8-20<br/>
                Sambata-Duminica: 10-18</br>
                Contact: 0756 318 976</br>
                       : 0760 489 168</br>
                E-mail: office@wildride.ro
            </p>
        </div>
    </div>    
</header>
<section id="container">
    <div class="content">
        <h1>Hi, <?php echo $_smarty_tpl->tpl_vars['customer']->value['nume'];?>
 <?php echo $_smarty_tpl->tpl_vars['customer']->value['prenume'];?>
</h1>
        <?php echo $_smarty_tpl->tpl_vars['customer']->value['message'];?>

        <p class="signature"><?php echo $_smarty_tpl->tpl_vars['sender']->value['name'];?>
</br>
           <?php echo $_smarty_tpl->tpl_vars['sender']->value['signature'];?>

        </p>
    </div>
</section>

<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<?php }} ?>