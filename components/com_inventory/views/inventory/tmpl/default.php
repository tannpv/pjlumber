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
$tmp = null;
?>
<link href="http://pjlumber.com/components/com_inventory/css/inventory.css" rel="stylesheet" type="text/css"/>

<div class ="inventory">
<table  cellspacing="0" cellpadding="0" class ="table_1">
    <tr style="vertical-align: top;">
        <?php 
		$count = count($this->items);
		$per = round(100/$count) - 2;
		// $per = 1;
		// var_dump($per);
        foreach ($this->items as $k => $item) { ?>
            <td>    
				<div class="main">
					<div class="title">
						<?php echo $item->title ?>
					</div>
					<div class="content">
						<div class="desc_title">Description</div>
						<div class="cl_title">C/L</div>
					</div>	
					<div class="content">
                    <?php for ($i = 0; $i < count($item->description); $i++) { ?>
						<div class="desc_content"><?php echo $this->escape($item->description[$i]) ?> </div>
						<div class="cl_content"><?php echo $item->cl[$i] ?></div>
                    <?php }  ?>   
					</div>					
				</div> 
            </td>
            <?php if ($k != (count($this->items) - 1)) { ?>
                <td class="seperate">&nbsp;</td>
            <?php } ?>
        <?php } ?>

    </tr>
</table>
</div>