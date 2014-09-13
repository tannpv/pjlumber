<?php
/**
 * @version     1.0.0
 * @package     com_manager
 * @copyright   Copyright (C) 2011. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by com_combuilder - http://www.notwebdesign.com
 */
// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHTML::_('script', 'system/multiselect.js', false, true);
$user = JFactory::getUser();
$userId = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
$canOrder = $user->authorise('core.edit.state', 'com_manager');
$saveOrder = $listOrder == 'a.ordering';
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">
    function submit_form(task,form_id)
    {
        alert(document.id('manager-form-'+form_id));
        if (task == 'inventorydetails.cancel' || document.formvalidator.isValid(document.id('manager-form-'+form_id))) {
            Joomla.submitform(task, document.getElementById('manager-form-'+form_id));
        }
        else {
            alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
        }
    }
</script>
<form action="<?php echo JRoute::_('index.php?option=com_manager&view=inventory'); ?>" method="post" name="adminForm" id="adminForm">
    <fieldset id="filter-bar">
        <div class="filter-search fltlft">
            <label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
            <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('Search'); ?>" />
            <button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
            <button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
        </div>
        <div class="filter-select fltrt">


            <select name="filter_published" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED'); ?></option>
                <?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true); ?>
            </select>


        </div>
    </fieldset>
    <div class="clr"> </div>

    <table class="adminlist">
        <thead>
            <tr>
                <th width="1%">
                    <input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" />
                </th>

                <th class='left'>
                    <?php echo JHtml::_('grid.sort', 'COM_MANAGER_MANAGERS_TITLE', 'a.title', $listDirn, $listOrder); ?>
                </th>
                <th class='left'>
                    <?php echo JHtml::_('grid.sort', 'COM_MANAGER_MANAGERS_DESCRIPTION', 'a.description', $listDirn, $listOrder); ?>
                </th>
                <!--
                <th width="1%" class="nowrap">
                    Action
                </th>
                -->
                <th width="1%" class="nowrap">
                    <?php echo JText::_('COM_MANAGER_MANAGERS_CL'); ?>
                </th>

                <?php if (isset($this->items[0]->state)) { ?>
                    <th width="5%">
                        <?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'a.state', $listDirn, $listOrder); ?>
                    </th>
                <?php } ?>
                <?php if (isset($this->items[0]->ordering)) { ?>
                    <th width="10%">
                        <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ORDERING', 'a.ordering', $listDirn, $listOrder); ?>
                        <?php if ($canOrder && $saveOrder) : ?>
                            <?php echo JHtml::_('grid.order', $this->items, 'filesave.png', 'managers.saveorder'); ?>
                        <?php endif; ?>
                    </th>
                <?php } ?>
                <?php if (isset($this->items[0]->id)) { ?>
                    <th width="1%" class="nowrap">
                        <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                    </th>
                <?php } ?>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="10">
                    <?php echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
        </tfoot>
        <tbody>
            <?php
            foreach ($this->items as $i => $item) :
                $ordering = ($listOrder == 'a.ordering');
                $canCreate = $user->authorise('core.create', 'com_manager');
                $canEdit = $user->authorise('core.edit', 'com_manager');
                $canCheckin = $user->authorise('core.manage', 'com_manager');
                $canChange = $user->authorise('core.edit.state', 'com_manager');
                ?>
            
                <tr class="row<?php echo $i % 2; ?>">
                    <form action="<?php echo JRoute::_('index.php?option=com_manager&layout=edit&id=' . (int) $item->id); ?>" method="post" name="adminForm-<?php echo (int)$item->id; ?>" id="manager-form-<?php echo (int)$item->id; ?>" class="form-validate">
                    <td class="center">
                        <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                        <input type="hidden" name="task" value="" />
                        <?php echo JHtml::_('form.token'); ?>
                    </td>

                    <td>
                        <?php if (isset($item->checked_out) && $item->checked_out) : ?>
                            <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'managers.', $canCheckin); ?>
                        <?php endif; ?>
                        <?php if ($canEdit) : ?>
                            <a href="<?php echo JRoute::_('index.php?option=com_manager&task=inventorydetails.edit&id=' . (int) $item->id); ?>">
                                <?php echo $this->escape($item->title); ?></a>
                        <?php else : ?>
                            <?php echo $this->escape($item->title); ?>
                        <?php endif; ?>
                        <!--<input type="text" value="<?php echo $this->escape($item->title); ?>" name="title" />-->
                    </td>
                    <td>
                        <?php echo $item->description; ?>
                        <!--<input type="text" value="<?php echo $item->description; ?>" name="title" />-->
                    </td>
                    <td>
                        <?php echo $item->cl; ?>
                    </td>
                    <!--
                    <td>
                        <input type="button" value="Submit" name="submit" onclick="submit_form('inventorydetails.save','<?php echo $item->id ?>')" />
                    </td>
                    -->
                    <?php if (isset($this->items[0]->state)) { ?>
                        <td class="center">
                            <?php echo JHtml::_('jgrid.published', $item->state, $i, 'managers.', $canChange, 'cb'); ?>
                        </td>
                    <?php } ?>
                    <?php if (isset($this->items[0]->ordering)) { ?>
                        <td class="order">
                            <?php if ($canChange) : ?>
                                <?php if ($saveOrder) : ?>
                                    <?php if ($listDirn == 'asc') : ?>
                                        <span><?php echo $this->pagination->orderUpIcon($i, true, 'managers.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                                        <span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'managers.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
                                    <?php elseif ($listDirn == 'desc') : ?>
                                        <span><?php echo $this->pagination->orderUpIcon($i, true, 'managers.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                                        <span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'managers.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php $disabled = $saveOrder ? '' : 'disabled="disabled"'; ?>
                                <input type="text" name="order[]" size="5" value="<?php echo $item->ordering; ?>" <?php echo $disabled ?> class="text-area-order" />
                            <?php else : ?>
                                <?php echo $item->ordering; ?>
                            <?php endif; ?>
                        </td>
                    <?php } ?>
                    <?php if (isset($this->items[0]->id)) { ?>
                        <td class="center">
                            <?php echo (int) $item->id; ?>
                        </td>
                    <?php } ?>
            </form>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>