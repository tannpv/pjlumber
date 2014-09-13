<?php
/**
 * @version     1.0.0
 * @package     com_inventory
 * @copyright   Copyright (C) 2011. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by com_combuilder - http://www.notwebdesign.com
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * HTML View class for the Inventory component
 */
class InventoryViewInventory extends JView
{
	protected $state;
	protected $item;

	function display($tpl = null)
	{
		$app = JFactory::getApplication();
        $params = $app->getParams();
        $ar_title = array();

        // Get some data from the models
        $state = $this->get('State');
        $item = $this->get('Item');


//                var_dump($item);
//                $count = count($ar_title);
        $inc = 0;
        foreach ($item as $key => $value) {
            if (!$key)
                $count = 0;
            else {
                if (trim($item[$key - 1]->title) != trim($value->title)) {
                    $count++;
                    $inc = 0;
                }
            }
            $ar_title[$count]->title = trim($value->title);
            $ar_title[$count]->description[$inc] = $value->description;
            $ar_title[$count]->cl[$inc] = $value->cl;
            $inc++;
        }
        $ar_title = array_values($ar_title);
//                print_r($ar_title);
        $this->assignRef('items', $ar_title);
        parent::display($tpl);
	}
}