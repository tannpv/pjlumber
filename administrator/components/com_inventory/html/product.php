<?php

/**
 * @version		$Id: category.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Framework
 * @subpackage		HTML
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
// no direct access
defined('_JEXEC') or die;

/**
 * Utility class for categories
 *
 * @static
 * @package		Joomla.Framework
 * @subpackage	HTML
 * @since		1.5
 */
abstract class JHtmlProduct {

    /**
     * @var	array	Cached array of the category items.
     */
    protected static $items = array();

    /**
     * Returns an array of categories for the given extension.
     *
     * @param	string	The extension option.
     * @param	array	An array of configuration options. By default, only published and unpulbished categories are returned.
     *
     * @return	array
     */
    public static function options($extension, $config = array('filter.state' => array(0, 1))) {
        $hash = md5($extension . '.' . serialize($config));

        if (!isset(self::$items[$hash])) {
            $config = (array) $config;
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
//            $db->setQuery(" select title from #__manager_inventory GROUP BY title  ORDER BY  id ");
            $query->select('a.title');
            $query->from('#__manager_inventory AS a');

            // Filter on the published state
            if (isset($config['filter.state'])) {
                if (is_numeric($config['filter.state'])) {
                    $query->where('a.state = ' . (int) $config['filter.state']);
                } else if (is_array($config['filter.state'])) {
                    JArrayHelper::toInteger($config['filter.state']);
                    $query->where('a.state IN (' . implode(',', $config['filter.state']) . ')');
                }
            }
            $query->group('a.title ');
            $query->order('a.ordering');
            
            $db->setQuery($query);

            $items = $db->loadObjectList();
            
            self::$items[$hash] = array();

            foreach ($items as &$item) {
                self::$items[$hash][] = JHtml::_('select.option', $item->title, $item->title);
            }
        }

        return self::$items[$hash];
    }   
}