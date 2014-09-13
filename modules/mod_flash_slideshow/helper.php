<?php

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

class ModFlash_slideshowHelper {

    /**
     * Returns a list of post items
     */
    public function getItems($userCount) {
        // get a reference to the database
        $db = &JFactory::getDBO();

        // get a list of $userCount
		// $select = "SELECT a.name ";
        // $from = "FROM `#__users` AS a ";
        // $where = "WHERE 1 ";
		
        // $order_by = "ORDER BY rand() LIMIT " . $userCount . '';
        // $query = $select.$from.$where.$order_by;
		
		$query	= $db->getQuery(true);
		$query->select('#__users.name');
		$query->from('#__users`');
		$query->where('1');
		$query->order("#__users.name");

        $db->setQuery($query);
        $items = ($items = $db->loadObjectList()) ? $items : array();

        return $items;
    }

//end getItems

    function myModuleReInstall($params) {
        if (!$params->get('is_installed')) {
            $database = & JFactory::getDBO();
            $query = "CREATE TABLE IF NOT EXISTS `example` ( `id` INT, `data` VARCHAR(100) );";

            $database->setQuery($query);
            $result = $database->query();

            $params->set('is_installed', 1);
        }
    }

}

//end ModModuleHelper
?>
