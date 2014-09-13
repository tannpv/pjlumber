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

class FlexicontactViewConfig_Template extends JView
{
function display($tpl = null)
{
	$template_name = $this->param1;			// param1 is the template name, 'user_template' or 'admin_template'
	
	if ($template_name == 'user_template')
		JToolBarHelper::title(LAFC_COMPONENT_NAME.': <small><small>'.JText::_('COM_FLEXICONTACT_CONFIG_USER_EMAIL_NAME').'</small></small>', 'flexicontact.png');
	else
		JToolBarHelper::title(LAFC_COMPONENT_NAME.': <small><small>'.JText::_('COM_FLEXICONTACT_CONFIG_ADMIN_EMAIL_NAME').'</small></small>', 'flexicontact.png');
	JToolBarHelper::apply();
	JToolBarHelper::save();
	JToolBarHelper::cancel();
	
// setup the key panel

	$keypanel = '<fieldset class="adminform">';
	$keypanel .= '<legend>'.JText::_('COM_FLEXICONTACT_VARIABLES').'</legend>';
	$keypanel .= '<table>';
	$keypanel .= '<tr><td>'.LAFC_T_FROM_NAME.'</td><td>'.JText::_('COM_FLEXICONTACT_NAME').'</td></tr>';
	$keypanel .= '<tr><td>'.LAFC_T_FROM_EMAIL.'</td><td>'.JText::_('COM_FLEXICONTACT_EMAIL').'</td></tr>';
	$keypanel .= '<tr><td>'.LAFC_T_MESSAGE_PROMPT.'</td><td>'.JText::_('COM_FLEXICONTACT_MESSAGE').' '.JText::_('COM_FLEXICONTACT_V_PROMPT').'</td></tr>';
	$keypanel .= '<tr><td>'.LAFC_T_MESSAGE_DATA.'</td><td>'.JText::_('COM_FLEXICONTACT_MESSAGE').' '.JText::_('COM_FLEXICONTACT_DATA').'</td></tr>';
	$keypanel .= '<tr><td>'.LAFC_T_SUBJECT.'</td><td>'.JText::_('COM_FLEXICONTACT_SUBJECT').'</td></tr>';
	$keypanel .= '<tr><td>'.LAFC_T_LIST_PROMPT.'</td><td>'.JText::_('COM_FLEXICONTACT_LIST').' '.JText::_('COM_FLEXICONTACT_V_PROMPT').'</td></tr>';
	$keypanel .= '<tr><td>'.LAFC_T_LIST_DATA.'</td><td>'.JText::_('COM_FLEXICONTACT_LIST').' '.JText::_('COM_FLEXICONTACT_DATA').'</td></tr>';
	$keypanel .= '<tr><td>'.LAFC_T_FIELD1_PROMPT.'</td><td>'.JText::_('COM_FLEXICONTACT_FIELD').' '.JText::_('COM_FLEXICONTACT_V_PROMPT').' 1</td></tr>';
	$keypanel .= '<tr><td>'.LAFC_T_FIELD1_DATA.'</td><td>'.JText::_('COM_FLEXICONTACT_FIELD').' '.JText::_('COM_FLEXICONTACT_DATA').' 1</td></tr>';
	$keypanel .= '<tr><td>'.LAFC_T_FIELD2_PROMPT.'</td><td>'.JText::_('COM_FLEXICONTACT_FIELD').' '.JText::_('COM_FLEXICONTACT_V_PROMPT').' 2</td></tr>';
	$keypanel .= '<tr><td>'.LAFC_T_FIELD2_DATA.'</td><td>'.JText::_('COM_FLEXICONTACT_FIELD').' '.JText::_('COM_FLEXICONTACT_DATA').' 2</td></tr>';
	$keypanel .= '<tr><td>'.LAFC_T_FIELD3_PROMPT.'</td><td>'.JText::_('COM_FLEXICONTACT_FIELD').' '.JText::_('COM_FLEXICONTACT_V_PROMPT').' 3</td></tr>';
	$keypanel .= '<tr><td>'.LAFC_T_FIELD3_DATA.'</td><td>'.JText::_('COM_FLEXICONTACT_FIELD').' '.JText::_('COM_FLEXICONTACT_DATA').' 3</td></tr>';
	$keypanel .= '<tr><td>'.LAFC_T_FIELD4_PROMPT.'</td><td>'.JText::_('COM_FLEXICONTACT_FIELD').' '.JText::_('COM_FLEXICONTACT_V_PROMPT').' 4</td></tr>';
	$keypanel .= '<tr><td>'.LAFC_T_FIELD4_DATA.'</td><td>'.JText::_('COM_FLEXICONTACT_FIELD').' '.JText::_('COM_FLEXICONTACT_DATA').' 4</td></tr>';
	$keypanel .= '<tr><td>'.LAFC_T_FIELD5_PROMPT.'</td><td>'.JText::_('COM_FLEXICONTACT_FIELD').' '.JText::_('COM_FLEXICONTACT_V_PROMPT').' 5</td></tr>';
	$keypanel .= '<tr><td>'.LAFC_T_FIELD5_DATA.'</td><td>'.JText::_('COM_FLEXICONTACT_FIELD').' '.JText::_('COM_FLEXICONTACT_DATA').' 5</td></tr>';
	$keypanel .= '<tr><td>'.LAFC_T_BROWSER.'</td><td>'.JText::_('COM_FLEXICONTACT_BROWSER').'</td></tr>';
	$keypanel .= '<tr><td>'.LAFC_T_IP_ADDRESS.'</td><td>'.JText::_('COM_FLEXICONTACT_IP_ADDRESS').'</td></tr>';
	$keypanel .= '</table>';
	$keypanel .= '</fieldset>';

// setup the wysiwg editor

	$editor = &JFactory::getEditor();
	
	?>
	<form action="index.php" method="post" name="adminForm" id="adminForm" >
	<input type="hidden" name="option" value="<?php echo LAFC_COMPONENT; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="view" value="config_template" />
	<input type="hidden" name="param1" value="<?php echo $template_name; ?>" />
	
	<?php 
	echo "\n".'<table><tr><td>';
	echo "\n".$editor->display($template_name, htmlspecialchars($this->config_data->$template_name, ENT_QUOTES),'700','350','60','20',array('pagebreak', 'readmore', 'article', 'image'));
	echo "\n".'</td><td>';
	echo $keypanel;
	echo "\n".'</td></tr></table>';
	?>
	</form>
	<?php 
}

}