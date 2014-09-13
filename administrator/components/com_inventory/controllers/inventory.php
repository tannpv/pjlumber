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

jimport('joomla.application.component.controllerform');

/**
 * Inventory controller class.
 */
class InventoryControllerInventory extends JControllerForm
{

    function __construct() {
        $this->view_list = 'inventories';
        parent::__construct();
    }

}