<?php
//no direct access
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
 
// include the helper file
require_once(dirname(__FILE__).DS.'helper.php');
 
// JHTML::_('behavior.mootools');
//var_dump($params->get('id'));
$aid = $params->get('id');
 
// get a parameter from the module's configuration
//$userCount = $params->get('usercount');
 
// get the items to display from the helper
$items = ModGrid2Helper::getItems($aid);
//ModModuleHelper::myModuleReInstall($params);
 
// include the template for display
require(JModuleHelper::getLayoutPath('mod_grid2', $params->get('layout', 'default')));
?>
