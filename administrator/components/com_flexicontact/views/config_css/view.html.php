<?php
/********************************************************************
Product    : Flexicontact
Date       : 25 July 2011
Copyright  : Les Arbres Design 2010-2011
Contact    : http://extensions.lesarbresdesign.info
Licence    : GNU General Public License
*********************************************************************/

defined('_JEXEC') or die('Restricted Access');

jimport('joomla.application.component.view');

class FlexicontactViewConfig_Css extends JView
{
function display($tpl = null)
{
	JToolBarHelper::title(LAFC_COMPONENT_NAME.': <small><small>'.JText::_('COM_FLEXICONTACT_CONFIG_CSS_NAME').'</small></small>', 'flexicontact.png');
	JToolBarHelper::apply('apply_css');
	JToolBarHelper::save('save_css');
	JToolBarHelper::cancel();
	
	$css_path = LAFC_SITE_ASSETS_PATH.DS.'com_flexicontact.css';
	
	if (!file_exists($css_path)) 
		{ 
		$app = &JFactory::getApplication();
		$app->redirect(LAFC_COMPONENT_LINK.'&task=config',
			JText::_('COM_FLEXICONTACT_CSS_MISSING').' ('.$css_path.')', 'error');
		return;
		}
		
	if (!is_readable($css_path)) 
		{ 
		$app = &JFactory::getApplication();
		$app->redirect(LAFC_COMPONENT_LINK.'&task=config',
			JText::_('COM_FLEXICONTACT_CSS_NOT_READABLE').' ('.$css_path.')', 'error'); 
		return;
		}

	if (!is_writable($css_path)) 
		{ 
		$app = &JFactory::getApplication();
		$app->redirect(LAFC_COMPONENT_LINK.'&task=config',
			JText::_('COM_FLEXICONTACT_CSS_NOT_WRITEABLE').' ('.$css_path.')', 'error'); 
		return;
		}
		
	$css_contents = @file_get_contents($css_path);
	
	?>
	<form action="index.php" method="post" name="adminForm" id="adminForm" >
	<input type="hidden" name="option" value="<?php echo LAFC_COMPONENT; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="view" value="config_css" />
	
	<?php 
	echo '<table><tr><td>';
	echo '<textarea name="css_contents" rows="25" cols="125">'.$css_contents .'</textarea>';
	echo '</td><td valign="top">';
	echo Flexicontact_Utility::make_info('www.w3schools.com/css','http://www.w3schools.com/css/default.asp');
	echo '</td></tr></table>';
	?>
	</form>
	<?php 
}

}