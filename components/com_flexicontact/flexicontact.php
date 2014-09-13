<?php
/********************************************************************
Product    : Flexicontact
Date       : 25 July 2011
Copyright  : Les Arbres Design 2009-2011
Contact    : http://extensions.lesarbresdesign.info
Licence    : GNU General Public License
*********************************************************************/
defined('_JEXEC') or die('Restricted Access');

// Pull in the helper file

require_once JPATH_COMPONENT_ADMINISTRATOR .DS.'helpers'.DS.'flexicontact_helper.php';

if (file_exists(JPATH_ROOT.DS.'LA.php'))
	require_once JPATH_ROOT.DS.'LA.php';

// load our css

$document = & JFactory::getDocument();
$document->addStyleSheet('components/'.LAFC_COMPONENT.'/assets/'.LAFC_COMPONENT.'.css');

jimport('joomla.application.component.controller');

require_once( JPATH_COMPONENT.DS.'controller.php' );
$controller = new FlexicontactController();

$task = JRequest::getVar('task');

$controller->execute($task);

$controller->redirect();

?>
