<?php
/********************************************************************
Product    : Flexicontact
Date       : 25 July 2011
Copyright  : Les Arbres Design 2010-2011
Contact    : http://extensions.lesarbresdesign.info
Licence    : GNU General Public License
*********************************************************************/

defined('_JEXEC') or die('Restricted Access');

jimport('joomla.application.component.controller');

// Pull in the helper file

require_once JPATH_COMPONENT.DS.'helpers'.DS.'flexicontact_helper.php';

if (file_exists(JPATH_ROOT.DS.'LA.php'))
	require_once JPATH_ROOT.DS.'LA.php';

// load our css

$document = & JFactory::getDocument();
$document->addStyleSheet(JURI::base().'components/'.LAFC_COMPONENT.'/assets/'.LAFC_COMPONENT.'.css');

// from Joomla 1.6.2 we need to load the Javascript framework

$version = new JVersion();
$joomla_version = $version->RELEASE;
if ($joomla_version >= '1.6')
	JHtml::_('behavior.framework');	// load the Joomla Javascript framework

// create an instance of the controller and tell it to execute $task

require_once( JPATH_COMPONENT.DS.'controller.php' );
$controller	= new FlexicontactController( );

$task = JRequest::getVar('task');

$controller->execute($task);

$controller->redirect();

