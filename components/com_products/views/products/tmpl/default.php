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
?>
<style>
    .products_block{
        clear: both;
        padding-bottom: 20px;
        width: 100%;
        display: inline-block;
    }
    .products_block div{
        border-color: #859FB9;
    }
    .products_title{
        clear: both;
        display: inline-block;
        padding-bottom: 5px;
        padding-right: 20px;
        padding-left: 20px;
    }
    .products_description{
        float: left;
        padding-right: 10px;
        border-top: thin solid;
        padding-top: 5px;
    }
    .products_picture{
        float: left;
        padding-left: 20px;
    }
    .products_body{
        float: left;
        width: 80%;
        border-right: thin solid;
    }
    .title h2{
        text-indent: 30%;
    }
</style>
<script>
    $(document).ready(function(){
        $(".products_a").colorbox({rel:'group2', transition:"fade"});
    });
</script>
<div class="title"><h2>Products & Services</h2></div>
<?php

foreach ($this->items as $item) {
//    $pattern = "/src=[\"']?([^\"']?.*(png|jpg|gif))[\"']?/i";
//    preg_match_all($pattern, $item->picture, $images);
    echo "<div class='products_block'>";
    echo "  <div class='products_body'>";
    echo "      <div class='products_title'><strong>{$item->title}</strong></div>";
    echo "      <div class='products_description'>{$item->description}</div>";
    echo "  </div>";
    echo "  <div class='products_picture'><a class='products_a' href='/".($item->image_full?$item->image_full:$item->image_thumb)."' title=''><img width='150' height='100' src='/{$item->image_thumb}'/></a></div>";
    echo "</div>";
}
?>