<?php

/**
 * @version     1.0.0
 * @package     com_products
 * @copyright   Copyright (C) 2011. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by com_combuilder - http://www.notwebdesign.com
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * HTML View class for the Products component
 */
class ProductsViewProducts extends JView {

    protected $state;
    protected $item;

    function display($tpl = null) {
        $app = JFactory::getApplication();
        $params = $app->getParams();
        $template = $app->getTemplate();

        // Get some data from the models
        $state = $this->get('State');
        $items = $this->get('Items');
        $this->assignRef('items', $items);

        $document = JFactory::getDocument();
        $document->addStyleSheet(JURI::base() . "templates/$template/css/colorbox.css");
//        $document->addScript(JURI::base() . "templates/$template/javascript/jquery.min.js");
//        $document->addScript(JURI::base() . "templates/$template/javascript/jquery.colorbox-min.js");

        parent::display($tpl);
    }

}