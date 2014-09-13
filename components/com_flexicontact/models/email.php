<?php
/********************************************************************
Product    : Flexicontact
Date       : 25 July 2011
Copyright  : Les Arbres Design 2010-2011
Contact    : http://extensions.lesarbresdesign.info
Licence    : GNU General Public License
*********************************************************************/
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class FlexicontactModelEmail extends JModel
{
var $_data;
var $_app = null;

function __construct()
{
	parent::__construct();
	$this->_app = &JFactory::getApplication();
}

//--------------------------------------------------------------------------------
// Get post data
//
function getPostData($config_data)
{
// Get the user name and email defaults
//
	switch ($config_data->autofill)
		{
		case 'off':
			$user_name = '';
			$user_email = '';
			break;
		case 'username':
			$user =& JFactory::getUser();
			$user_name = $user->username;
			$user_email = $user->email;
			break;
		case 'name':
			$user =& JFactory::getUser();
			$user_name = $user->name;
			$user_email = $user->email;
			break;
		}	
		
	$this->data->from_name = JRequest::getVar('from_name',$user_name);
	$this->data->from_email = JRequest::getVar('from_email',$user_email);
	$this->data->subject = JRequest::getVar('subject',$config_data->default_subject);
	$this->data->copy_me = JRequest::getVar('copy_me','');					// checkbox
	$this->data->agreement_check = JRequest::getVar('agreement_check','');		// checkbox
	$this->data->list1 = JRequest::getVar('list1','');
	$this->data->field1 = JRequest::getVar('field1','');
	$this->data->field2 = JRequest::getVar('field2','');
	$this->data->field3 = JRequest::getVar('field3','');
	$this->data->field4 = JRequest::getVar('field4','');
	$this->data->field5 = JRequest::getVar('field5','');
	$this->data->area_data = JRequest::getVar('area_data','');
	$this->data->magic_word = JRequest::getVar('magic_word','');
	$this->data->pic_selected = JRequest::getVar('picselected','');
	$this->data->pic_requested = JRequest::getVar('picrequested','');
	return $this->data;
}

// -------------------------------------------------------------------------------
// Initialise the errors array
//
function init_errors()
{
	$errors = array();
	$errors['message_not_sent'] = '';
	$errors['imageTest'] = '';
	$errors['from_name'] = '';
	$errors['from_email'] = '';
	$errors['subject'] = '';
	$errors['list'] = '';
	$errors['field1'] = '';
	$errors['field2'] = '';
	$errors['field3'] = '';
	$errors['field4'] = '';
	$errors['field5'] = '';
	$errors['area_data'] = '';
	$errors['magic_word'] = '';
	return $errors;
}

// -------------------------------------------------------------------------------
// Validate the user input
// Returns true if valid, false if not
//
function validate(&$errors, $config_data)
{
	$ret = true;
	
// if using captcha, validate the image

	if ($config_data->num_images > 0)
		{
		$pic_selected = substr(strtoupper($this->data->pic_selected),2);	// strip off the i_
		$targetText = JText::_('COM_FLEXICONTACT_IMAGE_'.$pic_selected);
		if (strcmp($this->data->pic_requested,$targetText) != 0)
			{
			$ret = false;
			$errors['imageTest'] = '<span class="fc_error">'.JText::_('COM_FLEXICONTACT_WRONG_PICTURE').'</span>';
			}
		}
	
// if using magic word, validate the word

	if ($config_data->magic_word != '')
		{
		if (strcasecmp($this->data->magic_word,$config_data->magic_word) != 0)
			{
			$ret = false;
			$errors['magic_word'] = '<span class="fc_error">'.JText::_('COM_FLEXICONTACT_WRONG_MAGIC_WORD').'</span>';
			}
		}
	
// validate the from name

	if (empty($this->data->from_name))
		{
		$ret = false;
		$errors['from_name'] = '<span class="fc_error">'.JText::_('COM_FLEXICONTACT_REQUIRED').'</span>';
		}

// validate the from address

	jimport('joomla.mail.helper');
	if (!JMailHelper::isEmailAddress($this->data->from_email))
		{
		$ret = false;
		$errors['from_email'] = '<span class="fc_error">'.JText::_('COM_FLEXICONTACT_BAD_EMAIL').'</span>';
		}

// validate the subject

	if (($config_data->show_subject) and (empty($this->data->subject)))
		{
		$ret = false;
		$errors['subject'] = '<span class="fc_error">'.JText::_('COM_FLEXICONTACT_REQUIRED').'</span>';
		}

// validate the list selection

	if (($config_data->list_opt == "mandatory") and (empty($this->data->list1)))
		{
		$ret = false;
		$errors['list'] = '<span class="fc_error">'.JText::_('COM_FLEXICONTACT_REQUIRED').'</span>';
		}

// validate field1

	if (($config_data->field_opt1 == "mandatory") and (empty($this->data->field1)))
		{
		$ret = false;
		$errors['field1'] = '<span class="fc_error">'.JText::_('COM_FLEXICONTACT_REQUIRED').'</span>';
		}

// validate field2

	if (($config_data->field_opt2 == "mandatory") and (empty($this->data->field2)))
		{
		$ret = false;
		$errors['field2'] = '<span class="fc_error">'.JText::_('COM_FLEXICONTACT_REQUIRED').'</span>';
		}

// validate field3

	if (($config_data->field_opt3 == "mandatory") and (empty($this->data->field3)))
		{
		$ret = false;
		$errors['field3'] = '<span class="fc_error">'.JText::_('COM_FLEXICONTACT_REQUIRED').'</span>';
		}

// validate field4

	if (($config_data->field_opt4 == "mandatory") and (empty($this->data->field4)))
		{
		$ret = false;
		$errors['field4'] = '<span class="fc_error">'.JText::_('COM_FLEXICONTACT_REQUIRED').'</span>';
		}

// validate field5

	if (($config_data->field_opt5 == "mandatory") and (empty($this->data->field5)))
		{
		$ret = false;
		$errors['field5'] = '<span class="fc_error">'.JText::_('COM_FLEXICONTACT_REQUIRED').'</span>';
		}

// validate area_data

	if (($config_data->area_opt == "mandatory") and (empty($this->data->area_data)))
		{
		$ret = false;
		$errors['area_data'] = '<span class="fc_error">'.JText::_('COM_FLEXICONTACT_REQUIRED').'</span>';
		}
		
	if (!$ret)
		$errors['message_not_sent'] = '<span class="fc_error">'.JText::_('COM_FLEXICONTACT_MESSAGE_NOT_SENT').'</span>';
	
	return $ret;
}

//-----------------------------------------
// Get client's IP address
//
function getIPaddress()
{
	if (isset($_SERVER["REMOTE_ADDR"]))
		return $_SERVER["REMOTE_ADDR"];
	if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
		return $_SERVER["HTTP_X_FORWARDED_FOR"];
	if (isset($_SERVER["HTTP_CLIENT_IP"]))
		return $_SERVER["HTTP_CLIENT_IP"];
	return "unknown";
} 

//-------------------------------------------------------------------------------
// Get client's browser (changed for 5.06)
// Returns 99 for unknown, 0 for msie, 1 for firefix, etc
//
function getBrowser(&$browser_string)
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $browser_string = 'Unknown';

    if (strstr($u_agent, 'MSIE') && !strstr($u_agent, 'Opera')) 
    	{ 
        $browser_string = 'MSIE'; 
        return 0; 
    	} 
    if (strstr($u_agent, 'Firefox')) 
    	{ 
        $browser_string = 'Firefox'; 
        return 1; 
    	} 
    if (strstr($u_agent, 'Chrome')) 	 // must test for Chrome before Safari!
    	{ 
        $browser_string = 'Chrome'; 
        return 3; 
    	} 
    if (strstr($u_agent, 'Safari')) 
    	{ 
        $browser_string = 'Safari'; 
        return 2; 
    	} 
    if (strstr($u_agent, 'Opera')) 
    	{ 
        $browser_string = 'Opera'; 
        return 4; 
    	} 
    if (strstr($u_agent, 'Netscape')) 
    	{ 
        $browser_string = 'Netscape'; 
        return 5; 
    	} 
    if (strstr($u_agent, 'Konqueror')) 
    	{ 
        $browser_string = 'Konqueror'; 
        return 6; 
    	} 
} 

//-------------------------------------------------------------------------------
// Resolve an email variable
//
function email_resolve($config_data, $variable)
{
	switch ($variable)
		{
		case LAFC_T_FROM_NAME:
			return $this->data->from_name;
		case LAFC_T_FROM_EMAIL:
			return $this->data->from_email;
		case LAFC_T_SUBJECT:
			return $this->data->subject;
		case LAFC_T_MESSAGE_PROMPT:
			return $config_data->area_prompt;
		case LAFC_T_MESSAGE_DATA:
			return $this->data->area_data;
		case LAFC_T_LIST_PROMPT:
			return $config_data->list_prompt;
		case LAFC_T_LIST_DATA:
			return $this->data->list_choice;
		case LAFC_T_FIELD1_PROMPT:
			return $config_data->field_prompt1;
		case LAFC_T_FIELD1_DATA:
			return $this->data->field1;
		case LAFC_T_FIELD2_PROMPT:
			return $config_data->field_prompt2;
		case LAFC_T_FIELD2_DATA:
			return $this->data->field2;
		case LAFC_T_FIELD3_PROMPT:
			return $config_data->field_prompt3;
		case LAFC_T_FIELD3_DATA:
			return $this->data->field3;
		case LAFC_T_FIELD4_PROMPT:
			return $config_data->field_prompt4;
		case LAFC_T_FIELD4_DATA:
			return $this->data->field4;
		case LAFC_T_FIELD5_PROMPT:
			return $config_data->field_prompt5;
		case LAFC_T_FIELD5_DATA:
			return $this->data->field5;
		case LAFC_T_BROWSER:
			return $this->data->browser_string;
		case LAFC_T_IP_ADDRESS:
			return $this->data->ip;
		default: return '';
		}
}

//-------------------------------------------------------------------------------
// Merge an email template with post data
//
function email_merge($template_text, $config_data)
{
	$text = $template_text;
	$variable_regex = "#%V_*(.*?)%#s";

	preg_match_all($variable_regex, $text, $variable_matches, PREG_SET_ORDER);

	foreach ($variable_matches as $match)
		{
		$resolved_text = $this->email_resolve($config_data, $match[0]);
		$text = str_replace($match[0], $resolved_text, $text);
		}

	return $text;
}

// -------------------------------------------------------------------------------
// Send the email
// Returns blank if ok, or an error message on failure
//
function sendEmail($config_data)
{
// get the user's ip address, browser, and list choice text

	$this->data->ip = $this->getIPaddress();
	$this->data->browser_id = $this->getBrowser($this->data->browser_string);
	if ($this->data->list1 != '')
		$this->data->list_choice = $config_data->list_array[$this->data->list1];
	else
		$this->data->list_choice = '';

// build the message to be sent to the site admin

	$body = $this->email_merge($config_data->admin_template, $config_data);
	jimport('joomla.mail.helper');
	$clean_body = JMailHelper::cleanBody($body);
	$clean_subject = JMailHelper::cleanSubject($this->data->subject);

// build the Joomla mail object

	$app = &JFactory::getApplication();
	$mail =& JFactory::getMailer();

	if ($config_data->email_html)
		$mail->IsHTML(true);
	else
		$clean_body = $this->html2text($clean_body);

	$mail->setSender(array($app->getCfg('mailfrom'), $app->getCfg('fromname')));
	$mail->addRecipient($config_data->toPrimary);
	if (!empty($config_data->ccAddress))
		$mail->addCC($config_data->ccAddress);
	if (!empty($config_data->bccAddress))
		$mail->addBCC($config_data->bccAddress);
	$mail->addReplyTo(array($this->data->from_email, $this->data->from_name));
	$mail->setSubject($clean_subject);
	$mail->setBody($clean_body);
	$ret_main = $mail->Send();
	if ($ret_main === true)
		$this->data->status_main = '1';
	else
		$this->data->status_main = $mail->ErrorInfo;
	
// if the user wanted a copy, send that separately

	if ($this->data->copy_me == 1)
		{
		$body = $this->email_merge($config_data->user_template, $config_data);
		$clean_body = JMailHelper::cleanBody($body);
		$mail =& JFactory::getMailer();
		if ($config_data->email_html)
			$mail->IsHTML(true);
		else
			$clean_body = $this->html2text($clean_body);
		$mail->setSender(array($app->getCfg('mailfrom'), $app->getCfg('fromname')));
		$mail->addRecipient($this->data->from_email);
		$mail->setSubject($clean_subject);
		$mail->setBody($clean_body);
		$ret_copy = $mail->Send();
		if ($ret_copy === true)
			$this->data->status_copy = '1';
		else
			$this->data->status_copy = $mail->ErrorInfo;
		}
	else
		$this->data->status_copy = '0';		// copy not requested
		
	return $this->data->status_main;		// both statuses are logged, but the main status decides what happens next
}

// -------------------------------------------------------------------------------
// Found at http://sb2.info/php-script-html-plain-text-convert/
//
function html2text($html)
{
    $tags = array (
    0 => '~<h[123][^>]+>~si',
    1 => '~<h[456][^>]+>~si',
    2 => '~<table[^>]+>~si',
    3 => '~<tr[^>]+>~si',
    4 => '~<li[^>]+>~si',
    5 => '~<br[^>]+>~si',
    6 => '~<p[^>]+>~si',
    7 => '~<div[^>]+>~si',
    );
    $html = preg_replace($tags,"\n",$html);
    $html = preg_replace('~</t(d|h)>\s*<t(d|h)[^>]+>~si',' - ',$html);
    $html = preg_replace('~<[^>]+>~s','',$html);
    // reducing spaces
    $html = preg_replace('~ +~s',' ',$html);
    $html = preg_replace('~^\s+~m','',$html);
    $html = preg_replace('~\s+$~m','',$html);
    // reducing newlines
    $html = preg_replace('~\n+~s',"\n",$html);
    return $html;
}

}
		
		