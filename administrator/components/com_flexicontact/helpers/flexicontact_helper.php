<?php
/********************************************************************
Product    : Flexicontact
Date       : 25 July 2011
Copyright  : Les Arbres Design 2010-2011
Contact    : http://extensions.lesarbresdesign.info
Licence    : GNU General Public License
*********************************************************************/
defined('_JEXEC') or die('Restricted Access');

define("LAFC_COMPONENT",      "com_flexicontact");
define("LAFC_COMPONENT_NAME", "FlexiContact");
define("LAFC_COMPONENT_LINK", "index.php?option=".LAFC_COMPONENT);
define("LAFC_ADMIN_ASSETS_URL",  JURI::root().'administrator/components/'.LAFC_COMPONENT.'/assets/');
define("LAFC_SITE_IMAGES_PATH",  JPATH_COMPONENT_SITE.DS.'images');
define("LAFC_SITE_ASSETS_PATH",  JPATH_COMPONENT_SITE.DS.'assets');

// email merge variables

define("LAFC_T_FROM_NAME",     "%V_FROM_NAME%");
define("LAFC_T_FROM_EMAIL",    "%V_FROM_EMAIL%");
define("LAFC_T_SUBJECT",       "%V_SUBJECT%");
define("LAFC_T_MESSAGE_PROMPT","%V_MESSAGE_PROMPT%");
define("LAFC_T_MESSAGE_DATA",  "%V_MESSAGE_DATA%");
define("LAFC_T_LIST_PROMPT",   "%V_LIST_PROMPT%");
define("LAFC_T_LIST_DATA",     "%V_LIST_DATA%");
define("LAFC_T_FIELD1_PROMPT", "%V_FIELD1_PROMPT%");
define("LAFC_T_FIELD1_DATA",   "%V_FIELD1_DATA%");
define("LAFC_T_FIELD2_PROMPT", "%V_FIELD2_PROMPT%");
define("LAFC_T_FIELD2_DATA",   "%V_FIELD2_DATA%");
define("LAFC_T_FIELD3_PROMPT", "%V_FIELD3_PROMPT%");
define("LAFC_T_FIELD3_DATA",   "%V_FIELD3_DATA%");
define("LAFC_T_FIELD4_PROMPT", "%V_FIELD4_PROMPT%");
define("LAFC_T_FIELD4_DATA",   "%V_FIELD4_DATA%");
define("LAFC_T_FIELD5_PROMPT", "%V_FIELD5_PROMPT%");
define("LAFC_T_FIELD5_DATA",   "%V_FIELD5_DATA%");
define("LAFC_T_BROWSER",       "%V_BROWSER%");
define("LAFC_T_IP_ADDRESS",    "%V_IP_ADDRESS%");

// log date filters

define("LAFC_LOG_ALL", 0);					// report filters
define("LAFC_LOG_LAST_7_DAYS", 1);
define("LAFC_LOG_LAST_28_DAYS", 2);
define("LAFC_LOG_LAST_12_MONTHS", 3);

class Flexicontact_Utility
{

// -------------------------------------------------------------------------------
// Draw the top menu and make the current item active
//
function addSubMenu($submenu = '')
{
	JSubMenuHelper::addEntry(JText::_('COM_FLEXICONTACT_CONFIGURATION'), 'index.php?option='.LAFC_COMPONENT.'&task=config', $submenu == 'config');
	JSubMenuHelper::addEntry(JText::_('COM_FLEXICONTACT_LOG'), 'index.php?option='.LAFC_COMPONENT.'&task=log_list', $submenu == 'log');
	JSubMenuHelper::addEntry(JText::_('COM_FLEXICONTACT_HELP_AND_SUPPORT'), 'index.php?option='.LAFC_COMPONENT.'&help', $submenu == 'help');
}
  
//-------------------------------------------------------------------------------
// Make a pair of boolean radio buttons
// $name          : Field name
// $current_value : Current value (boolean)
//
function make_radio($name,$current_value)
{
	$html = '';
	if ($current_value == 1)
		{
		$yes_checked = 'checked="checked" ';
		$no_checked = '';
		}
	else
		{
		$yes_checked = '';
		$no_checked = 'checked="checked" ';
		}
	$html .= ' <input type="radio" name="'.$name.'" value="1" '.$yes_checked.' /> '.JText::_('COM_FLEXICONTACT_V_YES')."\n";
	$html .= ' <input type="radio" name="'.$name.'" value="0" '.$no_checked.' /> '.JText::_('COM_FLEXICONTACT_V_NO')."\n";
	return $html;
}

//-------------------------------------------------------------------------------
// Make a select list
// $name          : Field name
// $current_value : Current value
// $list          : Array of ID => value items
// $first         : ID of first item to be placed in the list
// $extra         : Javascript or styling to be added to <select> tag
//
function make_list($name, $current_value, &$items, $first = 0, $extra='')
{
	$html = "\n".'<select name="'.$name.'" id="'.$name.'" class="input" size="1" '.$extra.'>';
	if ($items == null)
		return '';
	foreach ($items as $key => $value)
		{
		if (strncmp($key,"OPTGROUP_START",14) == 0)
			{
			$html .= "\n".'<optgroup label="'.$value.'">';
			continue;
			}
		if (strncmp($key,"OPTGROUP_END",12) == 0)
			{
			$html .= "\n".'</optgroup>';
			continue;
			}
		if ($key < $first)					// skip unwanted entries
			{
			continue;
			}
		$selected = '';

		if ($current_value == $key)
			$selected = ' selected="selected"';
		$html .= "\n".'<option value="'.$key.'"'.$selected.'>'.$value.'</option>';
		}
	$html .= '</select>'."\n";

	return $html;
}

//-------------------------------------------------------------------------------
// Make an info button
//
function make_info($title, $link='')
{
	$html = '';
	if ($link != '')
		$html .= '<a href="'.$link.'" target="_blank">';
		
	$html .= '<img src="'.LAFC_ADMIN_ASSETS_URL.'info-16.png" border="0" alt="" title="'.$title.'" />';
	
	if ($link != '')
		$html .= '</a>';#
		
	return $html;
}



}

?>


