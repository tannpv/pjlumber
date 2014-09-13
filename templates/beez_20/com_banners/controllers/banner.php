<?php

/**
 * @version		$Id: banner.php 20196 2011-01-09 02:40:25Z ian $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Banner controller class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_banners
 * @since		1.6
 */
class BannersControllerBanner extends JControllerForm {

    /**
     * @var		string	The prefix to use with controller messages.
     * @since	1.6
     */
    protected $text_prefix = 'COM_BANNERS_BANNER';

    /**
     * Method override to check if you can add a new record.
     *
     * @param	array	$data	An array of input data.
     *
     * @return	boolean
     * @since	1.6
     */
    protected function allowAdd($data = array()) {
        // Initialise variables.
        $user = JFactory::getUser();
        $categoryId = JArrayHelper::getValue($data, 'catid', JRequest::getInt('filter_category_id'), 'int');
        $allow = null;

        if ($categoryId) {
            // If the category has been passed in the URL check it.
            $allow = $user->authorise('core.create', $this->option . '.category.' . $categoryId);
        }

        if ($allow === null) {
            // In the absense of better information, revert to the component permissions.
            return parent::allowAdd($data);
        } else {
            return $allow;
        }
    }

    /**
     * Method override to check if you can edit an existing record.
     *
     * @param	array	$data	An array of input data.
     * @param	string	$key	The name of the key for the primary key.
     *
     * @return	boolean
     * @since	1.6
     */
    protected function allowEdit($data = array(), $key = 'id') {
        // Initialise variables.
        $user = JFactory::getUser();
        $recordId = (int) isset($data[$key]) ? $data[$key] : 0;
        $categoryId = 0;

        if ($recordId) {
            $categoryId = (int) $this->getModel()->getItem($recordId)->catid;
        }

        if ($categoryId) {
            // The category has been set. Check the category permissions.
            return $user->authorise('core.edit', $this->option . '.category.' . $categoryId);
        } else {
            // Since there is no asset tracking, revert to the component permissions.
            return parent::allowEdit($data, $key);
        }
    }

    public function build() {
        $db = &JFactory::getDbo();
        $query = $db->getQuery(true);
        $query = "SELECT * FROM pj_banners where state = '1' order by id";        //var_dump($query);
        $db->setQuery($query);

        $items = $db->loadObjectList();
        $xml = new DOMDocument("1.0", "utf-8");
        $diaporama = $xml->createElement("diaporama");
        $diaporama->setAttribute('ordre', 'sequential');
        $diaporama->setAttribute('fadeTime', '10');
        $diaporama->setAttribute('diapoInterval', '4');
        $diaporama->setAttribute('echelle', 'false');
        $diaporama->setAttribute('fontSize', '10');
        $xml->appendChild($diaporama);
        foreach ($items as $item) {
            $images = explode(",", $item->params);
            $iamgepath = explode(":", $images[0]);
            $path = str_replace(array("\"", "\\"), "", $iamgepath[1]);
            $image = $xml->createElement("image");
            $image->setAttribute('url', $path);
            $diaporama->appendChild($image);
        }
        $xml_string = $xml->saveXML();
        $File = JPATH_ROOT . "/images.xml";
        $Handle = fopen($File, 'w');
        fwrite($Handle, $xml_string);
        fclose($Handle);
        $msg = "successfully saved";
         //echo $xml_string;
         $this->setRedirect(JRoute::_('index.php?option=com_banners', false), $msg);
         //echo "Saved";
        return true;
    }

}