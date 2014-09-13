<?php
/**
 * @version     1.0.0
 * @package     com_inventory
 * @copyright   Copyright (C) 2011. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by com_combuilder - http://www.notwebdesign.com
 */


// no direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_inventory')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');
require_once(JPATH_COMPONENT . DS . "html" . DS . 'product.php');

$controller	= JController::getInstance('Inventory');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
