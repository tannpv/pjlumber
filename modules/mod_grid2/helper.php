<?php

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

class ModGrid2Helper {

    /**
     * Returns a list of post items
     */
    public function getItems($id) {
        // get a reference to the database
        $db = &JFactory::getDBO();

      
		 
		$query	= $db->getQuery(true);
		$query->select('title,introtext');
		$query->from('pj_content');
		$query->where('id = "'.$id.'"');
		$query->order("id");

        $db->setQuery($query);
//        print_r($query);
        $items = $db->loadObjectList();
//        print_r($query);
       // $items = ($items = $db->loadObjectList()) ? $items : array();
        
       
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
