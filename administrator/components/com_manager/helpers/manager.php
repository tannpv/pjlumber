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

/**
 * Manager helper.
 */
class ManagerHelper {

    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($vName = '') {
        $menu = ManagerHelper::getSubMenu();
        $default_view = NULL;
        foreach ($menu as $key => $item) {
            if ($item->active) {
                JSubMenuHelper::addEntry(
                        JText::_($item->title), $item->link, $vName ? $vName == $item->name : $item->default
                );
                $default_view = $item->default ? $item->name : $default_view;
            }
        }
        return $default_view;
    }

    private function getSubMenu() {
        $config = array();
        $config[0]->title = 'COM_MANAGER_TITLE_MANAGERS';
        $config[0]->link = 'index.php?option=com_manager&view=managers';
        $config[0]->name = 'managers';
        $config[0]->active = FALSE;
        $config[0]->default = FALSE;

        $config[1]->title = 'COM_MANAGER_TITLE_INVENTORY';
        $config[1]->link = 'index.php?option=com_manager&view=inventory';
        $config[1]->name = 'inventory';
        $config[1]->active = TRUE;
        $config[1]->default = FALSE;

        ManagerHelper::makeDefault($config, 1);
        return $config;
    }

    private function makeDefault(&$config, $index) {
        $config[$index]->default = TRUE;
    }

    /**
     * Gets a list of the actions that can be performed.
     *
     * @return	JObject
     * @since	1.6
     */
    public static function getActions() {
        $user = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_manager';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }

}
