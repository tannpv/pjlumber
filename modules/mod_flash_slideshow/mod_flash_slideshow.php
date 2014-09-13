<?php
//no direct access
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
 
// include the helper file
require_once(dirname(__FILE__).DS.'helper.php');
 
// JHTML::_('behavior.mootools');
$document 			= JFactory::getDocument();
// Get Module's Params
$title				= $params->get('title', "Simple Image Gallery");
$style				= $params->get('style', "border:1px solid #DDD; margin:0 5px 10px 5px; padding:5px; background:#fff;");
$path				= $params->get('path', "images/stories/fruit");

$styles 			= 'img.sp_simple_gallery {' . $style . '}'; 
// $document->addStyleSheet(JURI::base() . 'modules/mod_flash_slideshow/scripts/style.css');
// $document->addScript(JURI::base() . 'modules/mod_flash_slideshow/scripts/style.js');
// $document->addStyleDeclaration( $styles );
 
// get a parameter from the module's configuration
$userCount = $params->get('usercount');
 
// get the items to display from the helper
$items = ModFlash_slideshowHelper::getItems($userCount);
//ModModuleHelper::myModuleReInstall($params);
 
// include the template for display
require(JModuleHelper::getLayoutPath('mod_flash_slideshow', $params->get('layout', 'default')));
?>
