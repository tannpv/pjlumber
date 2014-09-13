<?php

/**
 * @version     1.0.0
 * @package     com_manager
 * @copyright   Copyright (C) 2011. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by com_combuilder - http://www.notwebdesign.com
 */
// No direct access
defined('_JEXEC') or die;

class ManagerController extends JController {

    /**
     * Method to display a view.
     *
     * @param	boolean			$cachable	If true, the view output will be cached
     * @param	array			$urlparams	An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
     *
     * @return	JController		This object to support chaining.
     * @since	1.5
     */
    public function display($cachable = false, $urlparams = false) {
        require_once JPATH_COMPONENT . '/helpers/manager.php';

        // Load the submenu.
        $default_view = ManagerHelper::addSubmenu(JRequest::getCmd('view'));

        $view = JRequest::getCmd('view', $default_view);
        JRequest::setVar('view', $view);

        parent::display();

        return $this;
    }

}
