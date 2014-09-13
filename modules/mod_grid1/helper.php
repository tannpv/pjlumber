<?php

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

class ModGrid1Helper {

    /**
     * Returns a list of post items
     */
    public function getItems($catid) {
        // get a reference to the database
        
        $db = &JFactory::getDBO();
        $query	= $db->getQuery(true);
//		$query->select('title,introtext');
//		$query->from('pj_content');
//		$query->where('id = "'.$id.'"');
//		$query->order("id");
               
               // $query = "select title,introtext,image from pj_content where catid = $cid ";
                 $query = "select c.id, c.title,c.introtext,c.image, c.catid
                        FROM
                        pj_content as c
                        INNER JOIN pj_categories as cat ON cat.id = c.catid
                        where cat.id = '" . $catid . "'";
                //var_dump($query);
        $db->setQuery($query);        //print_r($query);
        $items = $db->loadObjectList();
       
       //$items = '';

        return $items;
    }

//end getItems

    

}

//end ModModuleHelper
?>
