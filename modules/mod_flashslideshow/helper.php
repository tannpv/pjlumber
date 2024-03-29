<?php
/**
 *
 * $Id: helper.php 1.0.0 2011-12-04 22:00:52 Quang Long $
 * @package	    Commemorativeairforce 
 * @subpackage	Flash Slide Show
 * @version     1.0.0
 * @description 
 * @copyright	  Copyright © 2011 - All rights reserved.
 * @license		  GNU General Public License v2.0
 * @author		  Quang Long
 * @author mail	quanglong05@gmail.com
 * @website		  epiphanydev.com
 *
 * CODE GENERATED BY: ALEXEY GORDEYEV IK CODE GENERATOR
 * HTTP://WWW.AGJOOMLA.COM/
 *
 *
 * The module methods
 * -------------------------------
 * getItems()
 *
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
/**
 * Example Module Helper
 *
 * @package		  Commemorativeairforce
 * @subpackage	Flash Slide Show
 * @since 		  1.0.0
 * @class       ModFlashslideshowHelper
 */ 
 
class ModFlashslideshowHelper
{
	/**
	 * Do something getItems method
	 *
	 * @param 	
	 * @return
	 */
    public function getItems()
    {
        $db             =& JFactory::getDBO();
        $user		=& JFactory::getUser();
        
        $select = "SELECT * ";
        $from   = "FROM pj_banners ";
        $where  = "WHERE state = 1 AND catid = '15' ";
        
        $query = $select . $from . $where ;
        
        $db->setQuery($query);
        
        $items = $db->loadObjectList();
        
//        var_dump($items);
        
        return $items;
    } //end getItems
 
} // END ModFlashslideshowHelper

?>