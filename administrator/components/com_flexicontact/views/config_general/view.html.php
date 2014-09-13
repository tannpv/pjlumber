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

class FlexicontactViewConfig_General extends JView
{
function display($tpl = null)
{
	JToolBarHelper::title(LAFC_COMPONENT_NAME.': <small><small>'.JText::_('COM_FLEXICONTACT_CONFIG_GENERAL_NAME').'</small></small>', 'flexicontact.png');
	JToolBarHelper::apply();
	JToolBarHelper::save();
	JToolBarHelper::cancel();

// setup the three pre-populate options

	$options = array();
	$options['off'] = JText::_('COM_FLEXICONTACT_V_NO');
	$options['username'] = JText::_('COM_FLEXICONTACT_V_AUTOFILL_USERNAME');
	$options['name'] = JText::_('COM_FLEXICONTACT_NAME');
	$autofill_list = Flexicontact_Utility::make_list('autofill',$this->config_data->autofill, $options, 0, 'style="margin-bottom:0"');

	?>
	<form action="index.php" method="post" name="adminForm" id="adminForm" >
	<input type="hidden" name="option" value="<?php echo LAFC_COMPONENT; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="view" value="config_general" />
	<?php
	echo '<table>';
	
// logging

	echo "\n<tr>";
		echo '<td>'.JText::_('COM_FLEXICONTACT_LOGGING').'</td>';
		echo '<td>'.Flexicontact_Utility::make_radio('logging',$this->config_data->logging).'</td>';
	echo "\n</tr>";
	
// send html, yes/no

	echo "\n<tr>";
		echo '<td>'.JText::_('COM_FLEXICONTACT_HTML').'</td>';
		echo '<td>'.Flexicontact_Utility::make_radio('email_html',$this->config_data->email_html).'</td>';
	echo "\n</tr>";
	
// auto fill

	echo "\n<tr>";
		echo '<td valign="top">'.JText::_('COM_FLEXICONTACT_V_AUTOFILL').'</td>';
		echo '<td valign="top">'.$autofill_list.' '.Flexicontact_Utility::make_info(JText::_('COM_FLEXICONTACT_V_AUTOFILL_DESC')).'</td>';
	echo "\n</tr>";

// agreement required

	echo "\n<tr>";
		echo '<td>'.JText::_('COM_FLEXICONTACT_AGREEMENT_REQUIRED').'</td>';
		echo '<td>'.JText::_('COM_FLEXICONTACT_V_PROMPT').' <input type="text" size="40" name="agreement_prompt" value="'.$this->config_data->agreement_prompt.'" /></td>';
		echo '<td>'.JText::_('COM_FLEXICONTACT_NAME').' <input type="text" size="40" name="agreement_name" value="'.$this->config_data->agreement_name.'" /></td>';
		echo '<td>'.JText::_('COM_FLEXICONTACT_LINK').' <input type="text" size="60" name="agreement_link" value="'.$this->config_data->agreement_link.'" /> '.
			Flexicontact_Utility::make_info(JText::_('COM_FLEXICONTACT_AGREEMENT_REQUIRED_DESC')).'</td>';
	echo "\n</tr>";
		
	echo '</table></form>';
}

}