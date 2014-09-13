<?php
/********************************************************************
Product    : Flexicontact
Date       : 22 September 2011
Copyright  : Les Arbres Design 2009-2011
Contact    : http://extensions.lesarbresdesign.info
Licence    : GNU General Public License
*********************************************************************/
defined('_JEXEC') or die('Restricted Access');

jimport('joomla.application.component.controller');

class FlexicontactController extends JController
{
function display()
{
	$view = $this->getView('contact','html');

	$this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR.DS.'models');	// the log and config models are in the back end

	$config_model = $this->getModel('config');
	$config_data = $config_model->getData(true);		// get config data merged with menu parameters
	$view->assignRef('config_data',	$config_data);

	$email_model = $this->getModel('email');
	$errors = $email_model->init_errors();
	$view->assignRef('errors', $errors);
	
	$post_data = $email_model->getPostData($config_data);			// initialises all fields
	$view->assignRef('post_data', $post_data);
	
	$view->display();
}

function send()
{
	$this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR.DS.'models');	// the log and config models are in the back end

	$config_model = $this->getModel('config');
	$config_data = $config_model->getData(true);		// get config data merged with menu parameters

	$email_model = $this->getModel('email');
	$email_model->getPostData($config_data);
	$errors = $email_model->init_errors();
	$validation_result = $email_model->validate($errors, $config_data);

	if (!$validation_result)							// if validation failed
		{
		$view = $this->getView('contact','html');		// re-display the contact form
		$view->assignRef('config_data',	$config_data);
		$view->assignRef('errors', $errors);
		$view->assignRef('post_data', $email_model->data);
		$view->display();
		return;
		}

// here if validation ok

	$email_status = $email_model->sendEmail($config_data);
	
	if ($config_data->logging)
		{
		$log_model = $this->getModel('log');
		$log_model->store($email_model->data);
		}
		
	if ($email_status != '1')					// if send failed, show status using our _confirm view
		{
		$view = $this->getView('_confirm','html');
		$failed_message = JText::_('COM_FLEXICONTACT_MESSAGE_FAILED').': '.$email_status;
		$view->assignRef('message',	$failed_message);
		$view->display();
		return;
		}
		
// here if the email was sent ok

	if ($config_data->confirm_link)
		$this->setRedirect($config_data->confirm_link);
	else
		$this->setRedirect(JRoute::_('index.php?option=com_flexicontact&task=confirm', false));

	return;
}

function confirm()
{
	$this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR.DS.'models');	// the log and config models are in the back end

	$config_model = $this->getModel('config');
	$config_data = $config_model->getData(true);		// get config data merged with menu parameters
	$message = $config_data->confirm_text;				// get the confirmation text
	$view = $this->getView('_confirm','html');
	$view->assignRef('message',	$message);
	$view->display();
}

}
?>
