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

class FlexicontactViewLog_Detail extends JView
{
function display($tpl = null)
{
	JToolBarHelper::title(LAFC_COMPONENT_NAME.': <small><small>'.JText::_('COM_FLEXICONTACT_LOG').'</small></small>', 'flexicontact.png');
	JToolBarHelper::back();
	
	$log_data = &$this->log_data;

	$list_prompt = (isset($this->config_data->list_prompt)) ? $this->config_data->list_prompt : JText::_('COM_FLEXICONTACT_LIST').' '.JText::_('COM_FLEXICONTACT_DATA');

	echo '<table>';
	echo "\n".'<tr><td valign="top">'.JText::_('COM_FLEXICONTACT_DATE_TIME').'</td><td>'.$log_data->datetime.'</td></tr>';
	echo "\n".'<tr><td valign="top">'.JText::_('COM_FLEXICONTACT_NAME').'</td><td>'.$this->log_data->name.'</td></tr>';
	echo "\n".'<tr><td valign="top">'.JText::_('COM_FLEXICONTACT_EMAIL').'</td><td>'.$this->log_data->email.'</td></tr>';
	echo "\n".'<tr><td valign="top">'.JText::_('COM_FLEXICONTACT_SUBJECT').'</td><td>'.$this->log_data->subject.'</td></tr>';
	echo "\n".'<tr><td valign="top">'.JText::_('COM_FLEXICONTACT_MESSAGE').'</td><td>'.$this->log_data->message.'</td></tr>';
	if ($this->log_data->list_choice)	
		echo "\n".'<tr><td valign="top">'.$list_prompt.'</td><td>'.$this->log_data->list_choice.'</td></tr>';
	if ($this->log_data->field1)
		echo "\n".'<tr><td valign="top">'.$this->config_data->field_prompt1.'</td><td>'.$this->log_data->field1.'</td></tr>';
	if ($this->log_data->field2)
		echo "\n".'<tr><td valign="top">'.$this->config_data->field_prompt2.'</td><td>'.$this->log_data->field2.'</td></tr>';
	if ($this->log_data->field3)
		echo "\n".'<tr><td valign="top">'.$this->config_data->field_prompt3.'</td><td>'.$this->log_data->field3.'</td></tr>';
	if ($this->log_data->field4)
		echo "\n".'<tr><td valign="top">'.$this->config_data->field_prompt4.'</td><td>'.$this->log_data->field4.'</td></tr>';
	if ($this->log_data->field5)
		echo "\n".'<tr><td valign="top">'.$this->config_data->field_prompt5.'</td><td>'.$this->log_data->field5.'</td></tr>';
	echo "\n".'<tr><td valign="top">'.JText::_('COM_FLEXICONTACT_IP_ADDRESS').'</td><td>'.$this->log_data->ip.'</td></tr>';
	echo "\n".'<tr><td valign="top">'.JText::_('COM_FLEXICONTACT_BROWSER').'</td><td>'.$this->log_data->browser_string.'</td></tr>';
	echo "\n".'<tr><td valign="top">'.JText::_('COM_FLEXICONTACT_STATUS').'</td><td>'.$this->_status($this->log_data->status_main).'</td></tr>';
	echo "\n".'<tr><td valign="top">'.JText::_('COM_FLEXICONTACT_STATUS_COPY').'</td><td>'.$this->_status($this->log_data->status_copy).'</td></tr>';
	echo '</table>';
}

function _status($status)
{
	if ($status == '0')		// '0' status means no mail was sent
		return '';
	if ($status == '1')		// '1' means email was sent ok
		return '<img src="'.LAFC_ADMIN_ASSETS_URL.'tick.png" border="0" alt="" />';
	return $status;			// anything else was an error
}


}