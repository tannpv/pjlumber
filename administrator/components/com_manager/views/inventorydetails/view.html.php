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

jimport('joomla.application.component.view');

/**
 * View to edit
 */
class ManagerViewInventorydetails extends JView {

    protected $state;
    protected $item;
    protected $form;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->script = $this->get('Script');
        $this->state = $this->get('State');
        $this->item = $this->get('Item');
        $this->form = $this->get('Form');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode("\n", $errors));
            return false;
        }

        $this->addToolbar();
        parent::display($tpl);
        // Set the document
        $this->setDocument();
    }

    /**
     * Add the page title and toolbar.
     */
    protected function addToolbar() {
        JRequest::setVar('hidemainmenu', true);

        $user = JFactory::getUser();
        $isNew = ($this->item->id == 0);
        if (isset($this->item->checked_out)) {
            $checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
        } else {
            $checkedOut = false;
        }
        $canDo = ManagerHelper::getActions();

        JToolBarHelper::title(JText::_('COM_MANAGER_TITLE_MANAGER'), 'inventorydetails.png');

        // If not checked out, can save the item.
        if (!$checkedOut && ($canDo->get('core.edit') || ($canDo->get('core.create')))) {

            JToolBarHelper::apply('inventorydetails.apply', 'JTOOLBAR_APPLY');
            JToolBarHelper::save('inventorydetails.save', 'JTOOLBAR_SAVE');
        }
        if (!$checkedOut && ($canDo->get('core.create'))) {
            JToolBarHelper::custom('inventorydetails.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
        }
        // If an existing item, can save to a copy.
        if (!$isNew && $canDo->get('core.create')) {
            JToolBarHelper::custom('inventorydetails.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
        }
        if (empty($this->item->id)) {
            JToolBarHelper::cancel('inventorydetails.cancel', 'JTOOLBAR_CANCEL');
        } else {
            JToolBarHelper::cancel('inventorydetails.cancel', 'JTOOLBAR_CLOSE');
        }
    }

    protected function setDocument() {
        $isNew = ($this->item->id < 1);
        $document = JFactory::getDocument();
        $document->setTitle($isNew ? JText::_('COM_MANAGER_MANAGER_CREATING') : JText::_('COM_MANAGER_MANAGER_EDITING'));
//        $document->addScript(JURI::root() . $this->script);
//        $document->addScript(JURI::root() . "/administrator/components/com_manager/views/manager/submitbutton.js");
        JText::script('COM_MANAGER_MANAGER_ERROR_UNACCEPTABLE');
    }

}
