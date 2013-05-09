<?php
define("ROOT_PATH",str_replace("/install","",str_replace("\\","/",dirname(__FILE__))));
require(ROOT_PATH."/install/cls_smarty.php");
require(ROOT_PATH."/includes/lib_safe.php");
$smarty= new Smarty();
$smarty->template_dir   = ROOT_PATH . "/install/skins";
$smarty->cache_dir      = ROOT_PATH . '/install/caches';
$smarty->compile_dir    = ROOT_PATH . '/install/compiled';

?>