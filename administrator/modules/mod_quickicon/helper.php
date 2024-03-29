<?php
/**
 * @version		$Id: helper.php 21672 2011-06-24 22:04:46Z chdemko $
 * @package		Joomla.Administrator
 * @subpackage	mod_quickicon
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * @package		Joomla.Administrator
 * @subpackage	mod_quickicon
 * @since		1.6
 */
abstract class modQuickIconHelper
{
	/**
	 * Stack to hold default buttons
	 *
	 * @since	1.6
	 */
	protected static $buttons = array();

	/**
	 * Helper method to generate a button in administrator panel
	 *
	 * @param	array	A named array with keys link, image, text, access and imagePath
	 *
	 * @return	string	HTML for button
	 * @since	1.6
	 */
	public static function button($button)
	{
		if (!empty($button['access'])) {
			if (is_bool($button['access'])) {
				if ($button['access'] == false) {
					return '';
				}
			}
			else {

				// Take each pair of permission, context values.
				for ($i = 0, $n = count($button['access']); $i < $n; $i += 2) {
					if (!JFactory::getUser()->authorise($button['access'][$i], $button['access'][$i+1])) {
						return '';
					}
				}
			}
		}

		ob_start();
		require JModuleHelper::getLayoutPath('mod_quickicon', 'default_button');
		$html = ob_get_clean();
		return $html;
	}

	/**
	 * Helper method to return button list.
	 *
	 * This method returns the array by reference so it can be
	 * used to add custom buttons or remove default ones.
	 *
	 * @return	array	An array of buttons
	 * @since	1.6
	 */
	public static function &getButtons()
	{

		$user	= JFactory::getUser();
		$username = $user->username;
		
		if($username == 'admin'){
			if (empty(self::$buttons)) {
				self::$buttons = array(
					array(
						'link' => JRoute::_('index.php?option=com_content&task=article.add'),
						'image' => 'header/icon-48-article-add.png',
						'text' => JText::_('MOD_QUICKICON_ADD_NEW_ARTICLE'),
						'access' => array('core.manage', 'com_content', 'core.create', 'com_content', )
					),
					array(
						'link' => JRoute::_('index.php?option=com_content'),
						'image' => 'header/icon-48-article.png',
						'text' => JText::_('MOD_QUICKICON_ARTICLE_MANAGER'),
						'access' => array('core.manage', 'com_content')
					),
					array(
						'link' => JRoute::_('index.php?option=com_categories&extension=com_content'),
						'image' => 'header/icon-48-category.png',
						'text' => JText::_('MOD_QUICKICON_CATEGORY_MANAGER'),
						'access' => array('core.manage', 'com_content')
					),
					array(
						'link' => JRoute::_('index.php?option=com_media'),
						'image' => 'header/icon-48-media.png',
						'text' => JText::_('MOD_QUICKICON_MEDIA_MANAGER'),
						'access' => array('core.manage', 'com_media')
					),
					array(
						'link' => JRoute::_('index.php?option=com_menus'),
						'image' => 'header/icon-48-menumgr.png',
						'text' => JText::_('MOD_QUICKICON_MENU_MANAGER'),
						'access' => array('core.manage', 'com_menus')
					),
					array(
						'link' => JRoute::_('index.php?option=com_users'),
						'image' => 'header/icon-48-user.png',
						'text' => JText::_('MOD_QUICKICON_USER_MANAGER'),
						'access' => array('core.manage', 'com_users')
					),
					array(
						'link' => JRoute::_('index.php?option=com_modules'),
						'image' => 'header/icon-48-module.png',
						'text' => JText::_('MOD_QUICKICON_MODULE_MANAGER'),
						'access' => array('core.manage', 'com_modules')
					),
					array(
						'link' => JRoute::_('index.php?option=com_installer'),
						'image' => 'header/icon-48-extension.png',
						'text' => JText::_('MOD_QUICKICON_EXTENSION_MANAGER'),
						'access' => array('core.manage', 'com_installer')
					),
					array(
						'link' => JRoute::_('index.php?option=com_languages'),
						'image' => 'header/icon-48-language.png',
						'text' => JText::_('MOD_QUICKICON_LANGUAGE_MANAGER'),
						'access' => array('core.manage', 'com_languages')
					),
					array(
						'link' => JRoute::_('index.php?option=com_config'),
						'image' => 'header/icon-48-config.png',
						'text' => JText::_('MOD_QUICKICON_GLOBAL_CONFIGURATION'),
						'access' => array('core.manage', 'com_config', 'core.admin', 'com_config')
					),
					array(
						'link' => JRoute::_('index.php?option=com_templates'),
						'image' => 'header/icon-48-themes.png',
						'text' => JText::_('MOD_QUICKICON_TEMPLATE_MANAGER'),
						'access' => array('core.manage', 'com_templates')
					),
					array(
						'link' => JRoute::_('index.php?option=com_admin&task=profile.edit&id='.JFactory::getUser()->id),
						'image' => 'header/icon-48-user-profile.png',
						'text' => JText::_('MOD_QUICKICON_PROFILE'),
						'access' => true
					),
					array(
						'link' => JRoute::_('index.php?option=com_inventory'),
						'image' => 'header/icon_INVENTORY11.png',
						'text' => JText::_(''),
						'access' => array('core.manage', 'com_inventory')
					),
					array(
						'link' => JRoute::_('index.php?option=com_phocagallery'),
						'image' => 'header/icon-48-pg-phoca.png',
						'text' => JText::_('Photogallery'),
						'access' => array('core.manage', 'com_phocagallery')
					),
					array(
						'link' => JRoute::_('index.php?option=com_products'),
						'image' => 'header/icon-48-wood.png',
						'text' => JText::_('Product and Services'),
						'access' => array('core.manage', 'com_products')
					)
				);
			}
			
		}else if($username == 'pjmanager'){
			if (empty(self::$buttons)) {
				self::$buttons = array(
					array(
						'link' => JRoute::_('index.php?option=com_inventory'),
						'image' => 'header/icon_INVENTORY11.png',
						'text' => JText::_(''),
						'access' => array('core.manage', 'com_inventory')
					),
					array(
						'link' => JRoute::_('index.php?option=com_phocagallery'),
						'image' => 'header/icon-48-pg-phoca.png',
						'text' => JText::_('Photogallery'),
						'access' => array('core.manage', 'com_phocagallery')
					),
					// array(
						// 'link' => JRoute::_('index.php?option=com_banners'),
						// 'image' => 'header/icon-48-banner.png',
						// 'text' => JText::_('Banner'),
						// 'access' => array('core.manage', 'com_banners')
					// ),
					// array(
						// 'link' => JRoute::_('index.php?option=com_products'),
						// 'image' => 'header/icon-48-wood.png',
						// 'text' => JText::_('Product and Services'),
						// 'access' => array('core.manage', 'com_products')
					// )
				);
			}
		}
//		var_dump(self::$buttons);

		return self::$buttons;
	}
}
