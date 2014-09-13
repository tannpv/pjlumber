<?php
//no direct access
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
 
// include the helper file
require_once(dirname(__FILE__).DS.'helper.php');
 
$catid = $params->get('catid');
$items = ModGrid1Helper::getItems($catid);
//ModModuleHelper::myModuleReInstall($params);
 
// include the template for display
require(JModuleHelper::getLayoutPath('mod_grid1', $params->get('layout', 'default')));
?>
