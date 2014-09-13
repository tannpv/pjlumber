<?php
/**
 * @version                $Id: index.php 21518 2011-06-10 21:38:12Z chdemko $
 * @package                Joomla.Site
 * @subpackage	Templates.beez_20
 * @copyright        Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license                GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access.
ini_set('display_errors', 1);
error_reporting(E_ALL);
defined('_JEXEC') or die;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
    <head>
		<jdoc:include type="head" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>PJ Lumber</title>
        <link href="<?php echo $this->baseurl ?>/templates/beez_20/css/master.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $this->baseurl ?>/templates/beez_20/css/layout.css" rel="stylesheet" type="text/css" />
        <!--[if IE]>
        <link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/ieonly.css" rel="stylesheet" type="text/css" />
        <![endif]-->
        <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/javascript/jquery.min.js"></script>
        <!-- include Cycle plugin -->
        <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/javascript/jquery.cycle.all.2.74.js"></script>
        <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/javascript/jquery.colorbox-min.js"></script>
        <script type="text/javascript">
            WebFontConfig = {
                google: { families: ['Oswald'] }
            };
            (function() {
                var wf = document.createElement('script');
                wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                    '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
                wf.type = 'text/javascript';
                wf.async = 'true';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(wf, s);
            })();
        </script>
    </head>

    <body>
        <div class="bgrWrap">
            <div class="wrap clearfix">
                <!--wrap page-->
                <div class="header"></div>
                <!--start flash_slideshow-->
                <jdoc:include type="modules" name="flash_slideshow" />
                <!--end flash_slideshow-->
                <!-- nav-->
                <jdoc:include type="modules" name="menu" />
                <!-- /nav-->
                <!--start clearfix-->
                <jdoc:include type="modules" name="clearfix" />
                <!--end clearfix-->

                <!--start grid2-->
                <jdoc:include type="modules" name="grid2" />
                <!--end grid2-->
                <?php if($_REQUEST['Itemid'] != '435') { ?>
                <div class="grid3">
                    <jdoc:include type="message" />
                    <jdoc:include type="component" />
                </div>
                <?php  }?>
                <!--start grid1-->
                <jdoc:include type="modules" name="grid1" />
                <!--end grid1-->
                <!--end wrap-->

            </div>
        </div>
        <div class="clearfix"></div>
        <div class="footerWrap">
            <div class="footer clearfixs"><p>Copyright © 2003-2011 PJLumber.com. All Rights Reserved.  Privacy Policy </p>
            </div>
        </div>
    </body>
</html>
