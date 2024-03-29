<?php
/*
* @copyright Copyright (c) 2003 - 2011, CKSource - Frederico Knabben. All rights reserved.
* @license	 GNU/GPL
* CKEditor extension is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );
include_once('functions.php');
class plgEditorCKeditor extends JPlugin
{
	/**
	 * @access  protected
	 * @param   object  $subject The object to observe
	 * @param   array   $config  An array that holds the plugin configuration
	 * @since   1.0
	 */
	function plgEditorCKeditor( &$subject, $config )
	{
		parent::__construct( $subject, $config );
		$language = JFactory::getLanguage();
		$language->load('com_ckeditor', JPATH_ADMINISTRATOR, 'en-GB', true);
	}
	function onInit()
	{
		$document    = & JFactory::getDocument();
		$load = "\t<script type=\"text/javascript\">window.CKEDITOR_BASEPATH='".JURI::root()."plugins/editors/ckeditor/ckeditor/';</script>\n";
		if ($this->params->get( 'CKEditorJs', 0 ) == 1 && is_dir('../plugins/editors/ckeditor/ckeditor/_source/') && file_exists('../plugins/editors/ckeditor/ckeditor/ckeditor_source.js'))
		{
			$load .= "\t<script type=\"text/javascript\" src=\"".JURI::root(true).'/plugins/editors/ckeditor/ckeditor/ckeditor_source.js'."\"></script>\n";
		}else {
			$load .= "\t<script type=\"text/javascript\" src=\"".JURI::root(true).'/plugins/editors/ckeditor/ckeditor/ckeditor.js'."\"></script>\n";
		}
		return $load;
	}
	function onGetContent( $editor ) {
		return " CKEDITOR.instances.$editor.getData(); ";
	}
	function onSetContent($editor, $html) {
		return " CKEDITOR.instances.$editor.setData($html); ";
	}
	function onDisplay( $name, $content, $width, $height, $col, $row, $buttons = true, $id = null, $asset = null, $author = null)
	{
		//getApplication
		$app = JFactory::getApplication();
		//set cookie for ckfinder
		setcookie('ckfinder_app',$app->getClientId(), time()+ 60 * 60 * 24, '/' );
		//get frontend template name from database
		$db =JFactory::getDBO();
		$db->setQuery('SELECT template FROM #__template_styles WHERE home = 1 AND client_id='.$app->getClientId());
		$templateName = $db->loadResult();

		$session = JFactory::getSession();
		$user = JFactory::getUser();
		JHTML::_('behavior.modal', 'a.modal-button');
		if ((int)$width)
		{
			$width .= 'px';
		}
		if ((int)$height)
		{
			$height .= 'px';
		}
		$editor = '<textarea name="'.$name.'" id="'.$id.'" cols="'.$col.'" rows="'.$row.'" style="width:'.$width.'; height:'.$height.'">' .$content.   '</textarea>';
		$frontend = '';
		if(!strpos(JPATH_BASE,'administrator'))
		{
			$frontend = '_frontEnd';
		}
		//check language autodetect
		$language = '';
		if ($this->params->get( 'CKEditorAutoLang', 0 ) == 0)
		{
			//if autodetect is off set languege from language select
			$language = "language : '".$this->params->get( 'language', 'en' )."',";
		}else {
			//if autodecetct is on set default language
			$language .= "defaultLanguage : '".$this->params->get( 'language', 'en' )."',";
		}
		//set language direction
		if ($this->params->get( 'CKEditorLangDir', 0 ) == 1)
		{
			$txtDirection = "contentsLangDirection : 'rtl',";
		}else {
			$txtDirection = "contentsLangDirection : 'ltr',";
		}
			//scayt autostart
		if ($this->params->get( 'Scayt', 0 ) == 0)
		{
			$scayt = "scayt_autoStartup : false,";
		}else {
			$scayt = "scayt_autoStartup : true,";
		}
		if ($this->params->get( 'Entities', 1 ) == 0)
		{
			$entities = "entities : false,";
		}else {
			$entities = "entities : true,";
		}
		//set base href to works with default joomla editor
		$baseHref = "CKEDITOR.config.baseHref = '".JURI::root()."';";
		//iterate in ckeditor/plugins directory and add add external to all plugins added by user
		$pluginsPath ='';
		$pluginsName = array();

		foreach (glob(dirname(__FILE__)."/plugins/*",GLOB_ONLYDIR) AS $dir)
		{

			if ( $this->params->get( 'LinkBrowser', 1 ) == 0 && basename($dir) == "linkBrowser") continue;
			$pluginsName[] = basename($dir);
		$pluginsPath .= "CKEDITOR.plugins.addExternal('".basename($dir)."','../plugins/".basename($dir)."/');";
		}

		if ($this->params->get( 'LinkBrowserUrl', 1 ) == 0 )
		{
			$linkBrowserUrl = 'var linkBrowserUrl = "relative";';
		}else
		{
			$linkBrowserUrl = 'var linkBrowserUrl = "absolute";';
		}
		if ($this->params->get( 'CKEditorAutoGrow', 0 ) == 1)
		{
			$autogrow = ',autogrow';
		}else
		{
			$autogrow = '';
		}

		if ($this->params->get( 'CKEditorTableResize', 0 ) == 1)
		{
			$tableresize = ',tableresize';
		}else
		{
			$tableresize = '';
		}

		$editor .= "<script type='text/javascript'>
		$linkBrowserUrl
		CKEDITOR.config.extraPlugins = \"".implode(',',$pluginsName).$autogrow.$tableresize."\";
		$pluginsPath
		$baseHref
		CKEDITOR.config.customConfig = '../config.js';
		var CKEDITORInstance = CKEDITOR.replace( '".$name."',
		{
			resize_minWidth : '200',
			skin : '".$this->params->get( 'skin', 'kama' )."',
			".$language."
			".$txtDirection."
			".$scayt."
			".$entities."
			enterMode       : ".$this->params->get( 'enterMode','1').",
			shiftEnterMode  : ".$this->params->get( 'shiftEnterMode','2')."
			";

		if ($this->params->get( 'CKEditorWidth', '' ) > 0)
		{
			$editor .= ",width : '".$this->params->get( 'CKEditorWidth', '' )."'";
		}
		if ($this->params->get( 'CKEditorHeight', '' ) > 0)
		{
			$editor .= ",height : '".$this->params->get( 'CKEditorHeight', '' )."'";
			$editor .= ",autoGrow_maxHeight : '".$this->params->get( 'CKEditorHeight', '' )."'";
		}

		if ($this->params->get( 'Color', '' ) != '')
		{
			$editor .= ",uiColor : '".$this->params->get( 'Color', '' )."'";
		}
		//array with all elements added in toolbar
		$allElements = array();
		if($this->params->get( 'toolbar'.$frontend,'Full') != 'Full')
		{
			$toolbar = $this->params->get($this->params->get( 'toolbar'.$frontend,'Full').'_ToolBar'," 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink'");

			//check if config looks like standard CKeditor config
			if (strpos($toolbar,'[') !== false || strpos($toolbar,']') !== false)
			{
				//special parse for standard CKeditor config
				$toolbar = str_replace(array("[[","]]","[","]"),array("[","]","",";"),$toolbar);
			}
			//parse toolbar config
			$replace = array("'","`",'"',"\n");
			$replacement = array('','','','');
			$toolbar = str_replace($replace,$replacement,$toolbar);


			//preventing  put empty toolSet line
			$tmp = '';
			foreach (explode(',/,',$toolbar) AS $key => $line)
			{
				if ($line)
				{
					if ($key > 0)
					{
						$tmp .= ",/,".$line;
					}else
					{
						$tmp .= $line;
					}
				}
			}
			$toolbar = $tmp;


			$data = '';
			$toolbar = str_replace(array('/,;,/',  ',;,/'),array( '/', ',/'), $toolbar);
			foreach (explode(';',$toolbar) AS $menu)
			{
				if ($menu != '')
				{
					$data .="[";
					$tmpArray = array();

					foreach (explode(',',$menu) AS $key => $value)
					{
						$allElements[] = trim($value);
						if ($value != '' && trim($value) != '/')
						{
							$tmpArray[] = "'".trim($value)."'";
						}else if(trim($value) == '/')
						{
							//special case for "/" character
							//if "/" character is first in array -> move it before "[" character
							if ($data[strlen($data) -1] == "[" && $key < 2)
							{
								$data[strlen($data) - 1] = ']' ;
								$data .= ",'".trim($value)."',[";
							}else {
								$tmpArray[] = "],'".trim($value)."',[";
							}
						}
					}
					$data .= implode(',',$tmpArray);
					//correct data formating -> change ',]'' to ']' and '[,' to '['
					$data = preg_replace(array("#,[^'\[]#","#\[,#"),array(']','['),$data);
					$data .="],";
				}
			}
			//strip last ',' charcter
			$data[strlen($data ) - 1] = ' ';
		}
		$style = false;
		$style_file = trim($this->params->get('style',''));
		//set style
		if ($style_file != '')
		{
			if (file_exists(dirname(__FILE__).DS.'ckeditor'.DS.'styles'.DS.$style_file))
			{
				$editor .= ",stylesCombo_stylesSet  : 'default:".JURI::root()."plugins/editors/ckeditor/styles/".$style_file."'";
				// CKEditor 3.3 stylesCombo_stylesSet -> stylesSet
				$editor .= ",stylesSet  : 'default:".JURI::root()."plugins/editors/ckeditor/styles/".$style_file."'";
				$style = true;
			}
		}
		$template = false;
		$template_file = trim($this->params->get('template',''));
		//set template
		if ($template_file != '')
		{
			if (file_exists(dirname(__FILE__).DS."ckeditor".DS."templates".DS.$template_file))
			{
				$editor .= ",templates_files  :  ['".JURI::root()."/plugins/editors/ckeditor/templates/".$template_file."']";
				$editor .= ",templates : 'default'";
				$template = true;
			}
		}
		//add toolbar to editor
		//add Styles and Templates button only if they aren't defined in toolbar by user and required files exists
		if (isset($data)){
			$editor .= ",toolbar :[{$data}]";
		}

		//set css files
		$css = '';
		$css_files = trim($this->params->get('css',''));
		if ($css_files != '')
		{
			foreach (explode(';', $css_files) AS $file)
			{
				if (file_exists(dirname(__FILE__).DS.'ckeditor'.DS.'css'.DS.trim($file)))
				{
					$css .= ", '".JURI::root()."plugins/editors/ckeditor/css/".trim($file)."'";
				}
			}
		}

			if ($this->params->get('templateCss',0) == 1 && $templateName != null)
		{
			if ($app->getClientId() == 1)
			{

				if (file_exists(JPATH_BASE."/templates/$templateName/css/editor.css"))
				{
					$css .= ", '".JURI::root()."administrator/templates/$templateName/css/editor.css'";
				}else
				{
					$css .= ", '".JURI::root()."administrator/templates/$templateName/css/template.css'";
				}
			}
			else
			{
					if (file_exists(JPATH_BASE."/templates/$templateName/css/editor.css"))
					{
						$css .= ", '".JURI::root()."templates/$templateName/css/editor.css'";
					}else
					{
						$css .= ", '".JURI::root()."templates/$templateName/css/template.css'";
					}
			}
		}

		if ($css != '')
		{
			$editor .=  ",contentsCss  :  [ '".JURI::root()."plugins/editors/ckeditor/ckeditor/contents.css' {$css} ]";
		}

		if($this->params->get( 'ckfinder','1') == 1)
		{

			$gid = $user->get('groups');
			$access = $this->params->get( 'username_access',array('8'));

			$access_true = false;
			$sessionActive = false;
			$session->set('CKFinderAccess',false); //default false - user can't use CKFinder
			if ($this->params->get( 'CKFinderPathType',0) == 1)
			{
				$prefix = '';
			}
			else
			{
				$prefix = JURI::root();
			}

			if(is_array($access) && is_array($gid) )
			{
				foreach ($gid AS $key => $val)
				{
					if (in_array($val, $access))
					{
						$access_true = true;
						break;
					}
				}
			}
			else
			{
				if(is_array($gid) && in_array($access, $gid))
				{
					$access_true = true;
				}
			}

			if ($access_true)
			{
				if($session->getState() == 'active')
				{
					$sessionActive = true;
					$licenseKey = $this->params->get( 'PackageLicenseKey','');
					$licenseName = $this->params->get( 'PackageLicenseName','');
					$license = checkPackageLicense($licenseKey, $licenseName);

					$session->set('LicenseName',$this->params->get( 'PackageLicenseName',''));
					$session->set('LicenseKey',$license['key']);
//					if ($license['authenticate'] != true)
//						JError::raiseNotice( 100, JText::_('DEMO_MESSAGE'));
					$session->set('CKFinderAccess',true); //user can use CKFinder

					//set used sessions variables to default values
					$session->set('CKFinderMaxFilesSize',null);
					$session->set('CKFinderMaxFlashSize',null);
					$session->set('CKFinderMaxImagesSize',null);
					$session->set('CKFinderResourceFiles',null);
					$session->set('CKFinderResourceImages',null);
					$session->set('CKFinderResourceFlash',null);
					$session->set('CKFinderMaxImageWidth',null);
					$session->set('CKFinderMaxImageHeight',null);
					$session->set('CKFinderMaxThumbnailWidth',null);
					$session->set('CKFinderMaxThumbnailHeight',null);
					$session->set('CKFinderSettingsPlugins',null);
				}
			}
			if($access_true && $session->get('CKFinderAccess') && $this->params->get( 'ckfinder','0') != 0) // if user can use CKFinder  display button
			{
			if (file_exists(JPATH_BASE.DS."..".DS."plugins".DS."editors".DS."ckeditor".DS."ckfinder".DS.'ckfinder'.DS."ckfinder.php"))
			{
				$ckfinder_path = "plugins/editors/ckeditor/ckfinder/ckfinder/";
			}else{
				$ckfinder_path = "plugins/editors/ckeditor/ckfinder/";
			}
				$editor .= ",filebrowserBrowseUrl : '".JURI::root().$ckfinder_path."ckfinder.html',
					filebrowserImageBrowseUrl : '".JURI::root().$ckfinder_path."ckfinder.html?Type=Images',
					filebrowserFlashBrowseUrl : '".JURI::root().$ckfinder_path."ckfinder.html?Type=Flash',
					filebrowserUploadUrl : '".JURI::root().$ckfinder_path."core/connector/php/connector.php?command=QuickUpload&type=Files',
					filebrowserImageUploadUrl : '".JURI::root().$ckfinder_path."core/connector/php/connector.php?command=QuickUpload&type=Images',
					filebrowserFlashUploadUrl : '".JURI::root().$ckfinder_path."core/connector/php/connector.php?command=QuickUpload&type=Flash'";

				define('CKFINDER_PATH_BASE',str_replace(DS.'administrator','',JPATH_BASE));

				//configure save path for images
				//crete necessary folders if they don't exists

				$saveDir = $this->params->get( 'CKFinderSaveImages','media'.DS.'ckfinder'.DS.'images');
				$saveDir = str_replace('/',DS,$saveDir);
				$saveDir = str_replace(array('$id','$username'),array($user->id,$user->username),$saveDir);
				$session->set('CKFinderImagesPath',CKFINDER_PATH_BASE.DS.str_replace('/',DS,$saveDir).DS);
				$session->set('CKFinderImagesUrl', $prefix.str_replace('\\','/',trim($saveDir, '/')).'/');
				$chmod = octdec(trim($this->params->get( 'CKFinderSettingsChmod', '0755')));
				$old = umask(0);

				if ( $saveDir != 'media'.DS.'ckfinder'.DS.'images' && $saveDir != '')
				{
					$dirs = explode(DS,$saveDir);
					$path = CKFINDER_PATH_BASE;
					foreach ($dirs AS $dir)
					{
						$path = $path.DS.$dir;
						if (!is_dir($path))
						{
							if (!mkdir($path, $chmod, $chmod))
							{
								JError::raiseError(500, "Creating ".$path.' failed' );
							}
						}
					}
				}else{
					$saveDir = CKFINDER_PATH_BASE.DS.'media'.DS.'ckfinder'.DS.'images';
					$saveDir = str_replace('/',DS,$saveDir);
					if (!is_dir(CKFINDER_PATH_BASE.DS.'media'.DS.'ckfinder'))
					{
						if (!mkdir(CKFINDER_PATH_BASE.DS.'media'.DS.'ckfinder', $chmod))
						{
							JError::raiseError(500, "Creating ".CKFINDER_PATH_BASE.DS.'media'.DS.'ckfinder failed' );
						}
					}
					if (!is_dir($saveDir))
					{
						if (!mkdir($saveDir, $chmod))
						{
							JError::raiseError(500, "Creating ".$saveDir.' failed' );
						}
					}
				}
				//configure save path for flash files
				//crete necessary folders if they don't exists

				$saveDir = $this->params->get( 'CKFinderSaveFlash','media'.DS.'ckfinder'.DS.'flash');
				$saveDir = str_replace('/',DS,$saveDir);
				$saveDir = str_replace(array('$id','$username'),array($user->id,$user->username),$saveDir);
				$session->set('CKFinderFlashPath',CKFINDER_PATH_BASE.DS.str_replace('/',DS,$saveDir).DS);
				$session->set('CKFinderFlashUrl', $prefix.str_replace('\\','/',trim($saveDir, '/')).'/');

				if ( $saveDir != 'media'.DS.'ckfinder'.DS.'flash' && $saveDir != '')
				{
					$dirs = explode(DS,$saveDir);
					$path = CKFINDER_PATH_BASE;
					foreach ($dirs AS $dir)
					{
						$path = $path.DS.$dir;
						if (!is_dir($path))
						{
							if (!mkdir($path, $chmod))
							{
								JError::raiseError(500, "Creating ".$path.' failed' );
							}
						}
					}
				}else{
					$saveDir = CKFINDER_PATH_BASE.DS.'media'.DS.'ckfinder'.DS.'flash';
					$saveDir = str_replace('/',DS,$saveDir);
					if (!is_dir(CKFINDER_PATH_BASE.DS.'media'.DS.'ckfinder'))
					{
						if (!mkdir(CKFINDER_PATH_BASE.DS.'media'.DS.'ckfinder', $chmod))
						{
							JError::raiseError(500, "Creating ".CKFINDER_PATH_BASE.DS.'media'.DS.'ckfinder failed' );
						}
					}
					if (!is_dir($saveDir))
					{
						if (!mkdir($saveDir, $chmod))
						{
							JError::raiseError(500, "Creating ".$saveDir.' failed' );
						}
					}
				}
				//configure save path for files
				//crete necessary folders if they don't exists

				$saveDir = $this->params->get( 'CKFinderSaveFiles','media'.DS.'ckfinder'.DS.'files');
				$saveDir = str_replace('/',DS,$saveDir);
				$saveDir = str_replace(array('$id','$username'),array($user->id,$user->username),$saveDir);
				$session->set('CKFinderFilesPath',CKFINDER_PATH_BASE.DS.str_replace('/',DS,$saveDir).DS);
				$session->set('CKFinderFilesUrl', $prefix.str_replace('\\','/',trim($saveDir, '/')).'/');

				if ( $saveDir != 'media'.DS.'ckfinder'.DS.'files' && $saveDir != '')
				{
					$dirs = explode(DS,$saveDir);
					$path = CKFINDER_PATH_BASE;
					foreach ($dirs AS $dir)
					{
						$path = $path.DS.$dir;
						if (!is_dir($path))
						{
							if (!mkdir($path, $chmod))
							{
								JError::raiseError(500, "Creating ".$path.' failed' );
							}
						}
					}
				}else{
					$saveDir = CKFINDER_PATH_BASE.DS.'media'.DS.'ckfinder'.DS.'files';
					$saveDir = str_replace('/',DS,$saveDir);
					if (!is_dir(CKFINDER_PATH_BASE.DS.'media'.DS.'ckfinder'))
					{
						if (!mkdir(CKFINDER_PATH_BASE.DS.'media'.DS.'ckfinder', $chmod))
						{
							JError::raiseError(500, "Creating ".CKFINDER_PATH_BASE.DS.'media'.DS.'ckfinder failed' );
						}
					}
					if (!is_dir($saveDir))
					{
						if (!mkdir($saveDir, $chmod))
						{
							JError::raiseError(500, "Creating ".$saveDir.' failed' );
						}
					}
				}

				//configure save path for thumbnails
				//crete necessary folders if they don't exists

				$saveDir = $this->params->get( 'CKFinderSaveThumbs','media'.DS.'ckfinder'.DS.'_thumbs');
				$saveDir = str_replace('/',DS,$saveDir);
				$saveDir = str_replace(array('$id','$username'),array($user->id,$user->username),$saveDir);
				$session->set('CKFinderThumbsPath',CKFINDER_PATH_BASE.DS.str_replace('/',DS,$saveDir).DS);
				$session->set('CKFinderThumbsUrl', $prefix.str_replace('\\','/',trim($saveDir, '/')).'/');

				if ( $saveDir != 'media'.DS.'ckfinder'.DS.'_thumbs' && $saveDir != '')
				{
					$dirs = explode(DS,$saveDir);
					$path = CKFINDER_PATH_BASE;
					foreach ($dirs AS $dir)
					{
						$path = $path.DS.$dir;
						if (!is_dir($path))
						{
							if (!mkdir($path, $chmod))
							{
								JError::raiseError(500, "Creating ".$path.' failed' );
							}
						}
					}
				}else{
					$saveDir = CKFINDER_PATH_BASE.DS.'media'.DS.'ckfinder'.DS.'_thumbs';
					$saveDir = str_replace('/',DS,$saveDir);
					if (!is_dir(CKFINDER_PATH_BASE.DS.'media'.DS.'ckfinder'))
					{
						if (!mkdir(CKFINDER_PATH_BASE.DS.'media'.DS.'ckfinder', $chmod))
						{
							JError::raiseError(500, "Creating ".CKFINDER_PATH_BASE.DS.'media'.DS.'ckfinder failed' );
						}
					}
					if (!is_dir($saveDir))
					{
						if (!mkdir($saveDir, $chmod))
						{
							JError::raiseError(500, "Creating ".$saveDir.' failed' );
						}
					}
				}
				//return old umask settings
				umask($old);
				//settings for Resource Files
				if ( $this->params->get( 'CKFinderResourceFiles', ''))
				{
					$extensions = explode(',' , $this->params->get( 'CKFinderResourceFiles', ''));
					$extensions = array_unique($extensions);
					$results = array();
					foreach ($extensions AS $extension)
					{
						if ($extension)
						{
							$results[] = $extension;
						}
					}
					$session->set('CKFinderResourceFiles',implode(',',$results));
				}
				//settings for Resource Images
				if ( $this->params->get( 'CKFinderResourceImages', ''))
				{
					$extensions = explode(',' , $this->params->get( 'CKFinderResourceImages', ''));
					$extensions = array_unique($extensions);
					$results = array();
					foreach ($extensions AS $extension)
					{
						if ($extension)
						{
							$results[] = $extension;
						}
					}
					$session->set('CKFinderResourceImages',implode(',',$results));
				}
				//settings for Resource Flash
				if ( $this->params->get( 'CKFinderResourceFlash', ''))
				{
					$extensions = explode(',' , $this->params->get( 'CKFinderResourceFlash', ''));
					$extensions = array_unique($extensions);
					$results = array();
					foreach ($extensions AS $extension)
					{
						if ($extension)
						{
							$results[] = $extension;
						}
					}
					$session->set('CKFinderResourceFlash',implode(',',$results));
				}

				//set max Flash files size
				if ( $this->params->get( 'CKFinderMaxFlashSize', ''))
				{
					$session->set('CKFinderMaxFlashSize',$this->params->get( 'CKFinderMaxFlashSize'));
				}

				//set max Images files size
				if ( $this->params->get( 'CKFinderMaxImagesSize', ''))
				{
					$session->set('CKFinderMaxImagesSize',$this->params->get( 'CKFinderMaxImagesSize'));
				}

				//set max Files files size
				if ( $this->params->get( 'CKFinderMaxFilesSize', ''))
				{
					$session->set('CKFinderMaxFilesSize',$this->params->get( 'CKFinderMaxFilesSize'));
				}
				//set max image width
				if ( (int)$this->params->get( 'CKFinderMaxImageWidth', 0))
				{
					$session->set('CKFinderMaxImageWidth',(int)$this->params->get( 'CKFinderMaxImageWidth', 0));
				}
				//set max image height
				if ( (int)$this->params->get( 'CKFinderMaxImageHeight', 0))
				{
					$session->set('CKFinderMaxImageHeight',(int)$this->params->get( 'CKFinderMaxImageHeight', 0));
				}

				//set max thumbnail width
				if ( (int)$this->params->get( 'CKFinderMaxThumbnailWidth', 0))
				{
					$session->set('CKFinderMaxThumbnailWidth',(int)$this->params->get( 'CKFinderMaxThumbnailWidth', 0));
				}
				//set max thumbnail height
				if ( (int)$this->params->get( 'CKFinderMaxThumbnailHeight', 0))
				{
					$session->set('CKFinderMaxThumbnailHeight',(int)$this->params->get( 'CKFinderMaxThumbnailHeight', 0));
				}
				//plugins settings
				$plugins = array(
					'imageresize' => $this->params->get( 'CKFinderImageResize', 1),
					'fileedit' => $this->params->get( 'CKFinderFileEdit', 1),
				);
				$session->set('CKFinderSettingsPlugins',$plugins);

			}//end CKFinder config
		}
		$editor .= "});";
		//add custom javascript config from user,  very danger option
		$string = $this->params->get( 'CKEditorCustomJs', '' );
		$reg = "#/\*.+\*/#Us";
		$string = preg_replace($reg,'',$string);
		$editor .= $string;

		$instanceReady = $this->CKEditorInstance();

		$editor .= $instanceReady."</script>";
		//$editor .= $this->_displayButtons($name, $buttons);
		$editor .= $this->_displayButtons($id, $buttons, $asset, $author);
		//$editor .= $this->_toogleButton($name);
		return $editor;
	}

	function onGetInsertMethod($name)
	{
		$document =  JFactory::getDocument();
		$url = str_replace('administrator/', '', JURI::base() );
		$js= "function jInsertEditorText( text,editor ) {
			text = text.replace( /<img src=\"/, '<img src=\"".$url."' ); CKEDITOR.instances[editor].insertHtml( text);}";
		$document->addScriptDeclaration($js);
		return true;
	}


	/*function returns instanceReady event from CKEditor
	 * @return variable with javascript code , define CKEDitor instanceReady event
	 */
	function CKEditorInstance()
	{

	$txt = "
	CKEDITOR.on( 'instanceReady', function( ev )
	{
		var formater = [];
		formater['indent'] = ".$this->params->get('CKEditorIndent',1).";
		formater['breakBeforeOpen'] = ".$this->params->get('CKEditorBreakBeforeOpener',1).";
		formater['breakAfterOpen'] = ".$this->params->get('CKEditorBreakAfterOpener',1).";
		formater['breakBeforeClose'] = ".$this->params->get('CKEditorBreakBeforeCloser',0).";
		formater['breakAfterClose'] = ".$this->params->get('CKEditorBreakAfterCloser',1).";
		var pre_formater = ".$this->params->get('CKEditorPre',0).";
		var dtd = CKEDITOR.dtd;
		for ( var e in CKEDITOR.tools.extend( {}, dtd.\$nonBodyContent, dtd.\$block, dtd.\$listItem, dtd.\$tableContent ) ) {
			ev.editor.dataProcessor.writer.setRules( e, formater);
		}

		ev.editor.dataProcessor.writer.setRules( 'pre',
		{
			indent: pre_formater
		});
	});
";
		return $txt;
	}
	function _displayButtons($name, $buttons, $asset, $author)
	{
		// Load modal popup behavior
		JHTML::_('behavior.modal', 'a.modal-button');

		$args['name'] = $name;
		$args['event'] = 'onGetInsertMethod';

		$return = '';
		$results[] = $this->update($args);

		foreach ($results as $result)
		{
			if (is_string($result) && trim($result)) {
				$return .= $result;
			}
		}

		if (is_array($buttons) || (is_bool($buttons) && $buttons)) {
			$results = $this->_subject->getButtons($name, $buttons, $asset, $author);
			/*
			 * This will allow plugins to attach buttons or change the behavior on the fly using AJAX
			 */
			$return .= "\n<div id=\"editor-xtd-buttons\">\n";

			foreach ($results as $button)
			{
				/*
				 * Results should be an object
				 */
				if ( $button->get('name') ) {
					$modal		= ($button->get('modal')) ? 'class="modal-button"' : null;
					$href		= ($button->get('link')) ? 'href="'.JURI::base().$button->get('link').'"' : null;
					$onclick	= ($button->get('onclick')) ? 'onclick="'.$button->get('onclick').'"' : 'onclick="IeCursorFix(); return false;"';
					$return .= "<div class=\"button2-left\"><div class=\"".$button->get('name')."\"><a ".$modal." title=\"".$button->get('text')."\" ".$href." ".$onclick." rel=\"".$button->get('options')."\">".$button->get('text')."</a></div></div>\n";
				}
			}

			$return .= "</div>\n";
		}

		return $return;
	}

	function _toogleButton($name)
	{
		$return  = '';
		$return .= "\n<div class=\"toggle-editor\">\n";
		$return .= "<div class=\"button2-left\"><div class=\"blank\"><a href=\"#\" onclick=\"javascript:tinyMCE.execCommand('mceToggleEditor', false, '$name');return false;\" title=\"".JText::_('PLG_TINY_BUTTON_TOGGLE_EDITOR')."\">".JText::_('PLG_TINY_BUTTON_TOGGLE_EDITOR')."</a></div></div>";
		$return .= "</div>\n";

		return $return;
	}
}
