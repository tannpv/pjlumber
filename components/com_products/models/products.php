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

jimport('joomla.application.component.model');
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT . '/administrator/components/com_products/tables');

/**
 * Model
 */
class ProductsModelProducts extends JModel {

    protected $_item;

    /**
     * Get the data for a banner
     */
    function &getItems() {
        if (!isset($this->_item)) {
            $cache = JFactory::getCache('com_products', '');

            $id = $this->getState('products.id');

            $this->_item = $cache->get($id);

            if ($this->_item === false) {

                // redirect to banner url
                $db = $this->getDbo();
                $query = $db->getQuery(true);
                $query->select('a.*');
                $query->from('#__products_service as a');
                $query->where('a.state = 1');

                $db->setQuery((string) $query);
                if (!$db->query()) {
                    JError::raiseError(500, $db->getErrorMsg());
                }

                $this->_item = $db->loadObjectList();
                $cache->store($this->_item, $id);
            }
        }
        return $this->_item;
    }

}

