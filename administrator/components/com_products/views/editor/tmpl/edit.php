<?php
/**
 * @version     1.0.0
 * @package     com_products
 * @copyright   Copyright (C) 2011. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by com_combuilder - http://www.notwebdesign.com
 */
// no direct access
defined('_JEXEC') or die;
ini_set('display_errors', 0);
error_reporting(E_ALL);

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<script type="text/javascript">
    Joomla.submitbutton = function(task)
    {
        if (task == 'editor.cancel' || document.formvalidator.isValid(document.id('editor-form'))) {
            Joomla.submitform(task, document.getElementById('editor-form'));
        }
        else {
            alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_products&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="editor-form" class="form-validate">
    <div class="width-60 fltlft">
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_PRODUCTS_LEGEND_EDITOR'); ?></legend>
            <ul class="adminformlist">
                <li><?php echo $this->form->getLabel('id'); ?>
                    <?php echo $this->form->getInput('id'); ?></li>


                <li><?php echo $this->form->getLabel('state'); ?>
                    <?php echo $this->form->getInput('state'); ?></li><li><?php echo $this->form->getLabel('checked_out'); ?>
                    <?php echo $this->form->getInput('checked_out'); ?></li><li><?php echo $this->form->getLabel('checked_out_time'); ?>
                    <?php echo $this->form->getInput('checked_out_time'); ?></li>


                <li><?php echo $this->form->getLabel('title'); ?>
                    <?php echo $this->form->getInput('title'); ?></li>
            </ul>
            <div class="clr"></div>
            <?php echo $this->form->getLabel('description'); ?>
            <div class="clr"></div>
            <?php echo $this->form->getInput('description'); ?>


            <div class="clr"></div>
            <?php echo $this->form->getLabel('image_thumb'); ?>
            <div class="clr"></div>
            <?php echo $this->form->getInput('image_thumb'); ?>
            
            <div class="clr"></div>
            <?php echo $this->form->getLabel('image_full'); ?>
            <div class="clr"></div>
            <?php echo $this->form->getInput('image_full'); ?>
        </fieldset>
    </div>


    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
    <div class="clr"></div>
</form>