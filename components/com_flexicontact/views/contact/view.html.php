<?php
/********************************************************************
Product     : Flexicontact
Date       : 25 July 2011
Copyright   : Les Arbres Design 2009-2011
Contact     : http://extensions.lesarbresdesign.info
Licence     : GNU General Public License
*********************************************************************/
defined('_JEXEC') or die('Restricted Access');

jimport('joomla.application.component.view');

class FlexicontactViewContact extends JView
{
function display($tpl = null)
	{

// can't do anything without a "to" address

	if (empty($this->config_data->toPrimary))
		{
		echo "\n'To' address is not set in the menu item parameters";
		return;
		}

// display the input form

	echo "\n".'<div class="flexicontact">';
	if (!empty($this->config_data->page_hdr))
		echo "\n".'<h2>'.$this->config_data->page_hdr.'</h2>';
		
	if ($this->config_data->image == "-1")
		$imageHtml = "";
	else
		$imageHtml = '<img src="'.JURI::base().'images/'.$this->config_data->image.'" align="'.$this->config_data->image_align.'" alt="" style="padding:0 5px 0 5px" />';
	
	echo $imageHtml;
	
	if (!empty($this->config_data->page_text))
		{
		JPluginHelper::importPlugin('content');
		$page_text = JHtml::_('content.prepare', $this->config_data->page_text);
		echo "\n".'<div>'.$page_text.'</div>';
		}

	echo $this->errors['message_not_sent'];
	
// start the form
// we use getURI here in preference to the more usual JRoute::_('index.php')
// - this works well when FlexiContact is embedded in an article as an <object>

	$uri =& JFactory::getURI();
	$myuri = $uri->toString();
	echo '<form name="fc_form" action="'.$myuri.'" method="post" class="fc_form">
			<input type="hidden" name="task" value="send" />
			<table class="fc_table">';

// from name

	echo '<tr><td class="fc_prompt">'.JText::_('COM_FLEXICONTACT_FROM_NAME').'</td>
		  	<td class="fc_field">
			<input type="text" name="from_name" size="30" value="'.$this->escape($this->post_data->from_name).'" /> '.
				$this->errors['from_name'].'</td></tr>';

// from email address

	echo '<tr><td class="fc_prompt">'.JText::_('COM_FLEXICONTACT_FROM_ADDRESS').'</td>
		  	<td class="fc_field">
			<input type="text" name="from_email" size="30" value="'.$this->escape($this->post_data->from_email).'" /> '.
				$this->errors['from_email'].'</td></tr>';

// subject

	if ($this->config_data->show_subject)
		echo '<tr><td class="fc_prompt">'.JText::_('COM_FLEXICONTACT_SUBJECT').'</td>
			<td class="fc_field">
			<input type="text" name="subject" size="30" value="'.$this->escape($this->post_data->subject).'" /> '.
				$this->errors['subject'].'</td></tr>';

// the select list

	if ($this->config_data->list_opt != 'disabled')
		{
		$list_html = Flexicontact_Utility::make_list('list1',$this->post_data->list1, $this->config_data->list_array);
		echo "\n".'<tr><td class="fc_prompt">'.$this->config_data->list_prompt.'</td>
			<td class="fc_field">'.$list_html.' '.$this->errors['list'].'</td></tr>';
		}

// the five optional fields

	if ($this->config_data->field_opt1 != 'disabled')
		echo "\n".'<tr><td class="fc_prompt">'.$this->config_data->field_prompt1.'</td>
			<td class="fc_field">
			<input type="text" name="field1" size="30" value="'.$this->escape($this->post_data->field1).'" /> '.
			$this->errors['field1'].'</td></tr>';
				
	if ($this->config_data->field_opt2 != 'disabled')
		echo "\n".'<tr><td class="fc_prompt">'.$this->config_data->field_prompt2.'</td>
			<td class="fc_field">
			<input type="text" name="field2" size="30" value="'.$this->escape($this->post_data->field2).'" /> '.
			$this->errors['field2'].'</td></tr>';
				
	if ($this->config_data->field_opt3 != 'disabled')
		echo "\n".'<tr><td class="fc_prompt">'.$this->config_data->field_prompt3.'</td>
			<td class="fc_field">
			<input type="text" name="field3" size="30" value="'.$this->escape($this->post_data->field3).'" /> '.
			$this->errors['field3'].'</td></tr>';
			  
	if ($this->config_data->field_opt4 != 'disabled')
		echo "\n".'<tr><td class="fc_prompt">'.$this->config_data->field_prompt4.'</td>
			<td class="fc_field">
			<input type="text" name="field4" size="30" value="'.$this->escape($this->post_data->field4).'" /> '.
			$this->errors['field4'].'</td></tr>';
			
	if ($this->config_data->field_opt5 != "disabled")
		echo "\n".'<tr><td class="fc_prompt">'.$this->config_data->field_prompt5.'</td>
			<td class="fc_field">
			<input type="text" name="field5" size="30" value="'.$this->escape($this->post_data->field5).'" /> '.
			$this->errors['field5'].'</td></tr>';

// the main text area

	if ($this->config_data->area_opt != 'disabled')
		echo "\n".'<tr><td valign="top" class="fc_prompt">'.$this->config_data->area_prompt.'</td>
			<td class="fc_field">
			<textarea name="area_data" rows="'.$this->config_data->area_height.'" cols="'.$this->config_data->area_width.'">'.$this->escape($this->post_data->area_data).'</textarea>
			<br />'.$this->errors['area_data'].'</td></tr>';

// the "send me a copy" checkbox

	if ($this->config_data->show_copy)
		{
		if ($this->post_data->copy_me)
			$checked = 'checked = "checked"';
		else
			$checked = '';
		$checkbox = '<input type="checkbox" name="copy_me" value="1" '.$checked.'/>';
		echo '<tr><td colspan="2" class="fc_field">'.$checkbox.' ';
		echo JText::_('COM_FLEXICONTACT_COPY_ME').'</td></tr>';
		}
	
// the agreement required checkbox

	$send_button_state = '';
	if ($this->config_data->agreement_prompt != '')
		{
		if ($this->post_data->agreement_check)
			$checked = 'checked = "checked"';
		else
			{
			$send_button_state = 'disabled="disabled"';
			$checked = '';
			}
		$onclick = ' onclick="if(this.checked==true){form.send_button.disabled=false;}else{form.send_button.disabled=true;}"';
		$checkbox = '<input type="checkbox" name="agreement_check" value="1" '.$checked.$onclick.'/>';
		if (($this->config_data->agreement_name != '') and ($this->config_data->agreement_link != ''))
			{
			$popup = 'onclick="window.open('."'".$this->config_data->agreement_link."', 'fcagreement', 'width=640,height=480,scrollbars=1,location=0,menubar=0,resizable=1'); return false;".'"';
			$link_text = $this->config_data->agreement_prompt.' '.JHTML::link($this->config_data->agreement_link, $this->config_data->agreement_name, 'target="_blank" '.$popup);
			}
		else
			$link_text = $this->config_data->agreement_prompt;
		echo '<tr><td colspan="2" class="fc_field">'.$checkbox.' '.$link_text.'</td></tr>';
		}

// the magic word

	if ($this->config_data->magic_word != '')
		{
		echo "\n".'<tr><td class="fc_prompt">'.JText::_('COM_FLEXICONTACT_MAGIC_WORD').'</td>
			<td class="fc_field">
			<input type="text" name="magic_word" size="30" value="'.$this->post_data->magic_word.'" />'.
			$this->errors['magic_word'].'</td></tr>';
		}

// the image captcha

	if ($this->config_data->num_images > 0)
		{
		echo "\n".'<tr><td colspan="2" class="fc_images">';
			echo $this->errors['imageTest'].'<br />';
		$this->displayImageTest($this->config_data); 
		echo '</td></tr>';
		}

// the send button

	echo "\n".'<tr><td colspan="2" class="fc_button">';
	echo '<input type="submit" name="send_button" '.$send_button_state.' value="'.JText::_('COM_FLEXICONTACT_SEND_BUTTON').'" />';
	echo '</td></tr>';
	echo '</table>';

// bottom text

	if (!empty($this->config_data->bottom_text))
		{
		JPluginHelper::importPlugin('content');
		$bottom_text = JHtml::_('content.prepare', $this->config_data->bottom_text);
		echo "\n".'<div>'.$bottom_text.'</div>';
		}
		
	echo '</form>';
	echo '</div>';				// class="flexicontact"
}

// -------------------------------------------------------------------------------
// Display the image test
// Returns the description of the target image
//
function displayImageTest($config_data)
{

// get list of images in images directory

    $images = array();					// create array
    $handle = opendir(LAFC_SITE_IMAGES_PATH);
	if (!$handle)
		{
		echo "Images directory not found";
		return;
		}
		
	while (($filename = readdir($handle)) != false)
	    {
    	if ($filename == '.' or $filename == '..')
    		continue;
    	$imageInfo = @getimagesize(LAFC_SITE_IMAGES_PATH.DS.$filename);
    	if ($imageInfo === false)
    		continue;				// not an image
    	if ($imageInfo[3] > 3)		// only support gif, jpg or png
    		continue;
    	if ($imageInfo[0] > 150)	// if X size > 150 pixels ..
    		continue;				// .. it's too big so skip it
    	$images[] = $filename;		// add to array
    	}
    closedir($handle);
    if (empty($images))
		{
		echo "No suitable images in images directory";
		return;
		}
	$imageCount = count($images);
	if ($imageCount < $config_data->num_images)
		{
		echo 'Not enough images in images directory. Requested: '.$config_data->num_images.' Found: '.$imageCount.'<br />';
		echo 'Please check the menu item<br />';
		return;
		}
		
// choose the images
	
	$i = 0;
	$randoms = array();
	while ($i < $config_data->num_images)
		{
		$imageNum = rand(0,$imageCount - 1);	// get a random number
		if (in_array($imageNum,$randoms))		// if already chosen
			continue;							// try again
		$randoms[] = $imageNum;					// add to random number array
		$i ++;									// got one more
		}
		
// choose the target image, get its description and make the prompt
	
	$i = rand(0, $config_data->num_images - 1);
	$j = $randoms[$i];
	$targetImage = $images[$j];
	$targetText = JText::_('COM_FLEXICONTACT_IMAGE_'.strtoupper($targetImage));
	if (JText::_('COM_FLEXICONTACT_OBJECT_FIRST') == "Yes")
		echo $targetText.' '.JText::_('COM_FLEXICONTACT_SELECT_IMAGE').'<br />';
	else
		echo JText::_('COM_FLEXICONTACT_SELECT_IMAGE').' '.$targetText.'<br />';
	
// javascript to handle highlighting
	
	echo '<script type="text/javascript">';
	echo "<!--
			function imageSelect(pictureID)
			{	var images = document.getElementsByName('fc_image');
				for (var i = 0; i < images.length; i++)
					images[i].className = 'fc_inactive';
				document.getElementById(pictureID).className = 'fc_active';
				document.fc_form.picselected.value = pictureID;	} 
		 //--> </script>";

// output the images
	
	echo '<div align="center">';
	for ($i = 0; $i < $config_data->num_images; $i++)
		{
		$j = $randoms[$i];
		$imageName = $images[$j];		// get the filename
		$imageName = $images[$j];		// get the filename
		$imageHtml = '<img id="i_'.$imageName.'" name="fc_image" src="components/com_flexicontact/images/'.$imageName.'" alt="" class="fc_inactive" onclick="imageSelect('."'i_".$imageName."'".')" />';
		echo "\n".$imageHtml."\n";
		}
	echo '</div>';
	echo '<input type="hidden" name="picselected" value="" />';
	echo '<input type="hidden" name="picrequested" value="'.$targetText.'" />';
}

	
}
?>
