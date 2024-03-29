<?php
/*
 * CKFinder : configuration file for Joomla!
 */

define( '_JEXEC', 1 );
define( 'DS', DIRECTORY_SEPARATOR );
$rootFolder = explode(DS,dirname(__FILE__));
array_splice($rootFolder,-4);
$base_folder = implode(DS,$rootFolder);
define('JPATH_BASE',str_replace('\plugins','',$base_folder));

require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );

if ($_COOKIE['ckfinder_app'] == 1)
{
	$mainframe =& JFactory::getApplication('administrator');
}else
{
	$mainframe =& JFactory::getApplication('site');
}
$mainframe->initialise();

function CheckAuthentication()
{

	// WARNING : DO NOT simply return "true". By doing so, you are allowing
	// "anyone" to upload and list the files on your server. You must implement
	// some kind of session validation here. Even something very simple such as...

	//get joomla session
	$session =& JFactory::getSession();
	if($session->getState() == 'active' && $session->get('CKFinderAccess') == true)
	{
		// If license name and key are set in plugin config, use them.
		if ($session->get('LicenseName') !='' && $session->get('LicenseKey') != '')
		{
			$GLOBALS['config']['LicenseName'] = trim($session->get('LicenseName'), ' "');
			$GLOBALS['config']['LicenseKey'] = trim($session->get('LicenseKey'), ' "');
		}
		else
		{ // Set CKFinder to demonstration mode.
			$GLOBALS['config']['LicenseName'] = '';
			$GLOBALS['config']['LicenseKey'] = '';
		}

		return true;
	}
	return false;
}
$session =& JFactory::getSession();

/*
 * Uncomment lines below to enable PHP error reporting and displaying PHP errors.
 * Do not do this on a production server. Might be helpful when debugging why CKFinder does not work as expected.
 */
$baseUrl = 'media/';
$baseDir = JPATH_BASE.DS."media";

$config['Thumbnails'] = Array(
		'url' => ($session->get('CKFinderThumbsUrl'))?$session->get('CKFinderThumbsUrl'):$baseUrl . '_thumbs',
		'directory' =>  ($session->get('CKFinderThumbsPath'))?$session->get('CKFinderThumbsPath'):$baseDir . '_thumbs',
		'enabled' => true,
		'directAccess' => false,
		'maxWidth' => ($session->get('CKFinderMaxThumbnailWidth'))?$session->get('CKFinderMaxThumbnailWidth'):100,
		'maxHeight' => ($session->get('CKFinderMaxThumbnailHeight'))?$session->get('CKFinderMaxThumbnailHeight'):100,
		'bmpSupported' => false,
		'quality' => 80);

$config['Images'] = Array(
		'maxWidth' => ($session->get('CKFinderMaxImageWidth'))?$session->get('CKFinderMaxImageWidth'):1600,
		'maxHeight' => ($session->get('CKFinderMaxImageHeight'))?$session->get('CKFinderMaxImageHeight'):1200,
		'quality' => 80);

$config['RoleSessionVar'] = 'CKFinder_UserRole';

$config['AccessControl'][] = Array(
		'role' => '*',
		'resourceType' => '*',
		'folder' => '/',

		'folderView' => true,
		'folderCreate' => true,
		'folderRename' => true,
		'folderDelete' => true,

		'fileView' => true,
		'fileUpload' => true,
		'fileRename' => true,
		'fileDelete' => true);

$config['DefaultResourceTypes'] = '';

$config['ResourceType'][] = Array(
		'name' => 'Files',        // Single quotes not allowed
		'url' => ($session->get('CKFinderFilesUrl'))?$session->get('CKFinderFilesUrl'):$baseUrl . 'files',
		'directory' => ($session->get('CKFinderFilesPath'))?$session->get('CKFinderFilesPath'):$baseDir . 'files',
		'maxSize' => ($session->get('CKFinderMaxFilesSize'))?$session->get('CKFinderMaxFilesSize'):0,
		'allowedExtensions' =>($session->get('CKFinderResourceFiles'))?$session->get('CKFinderResourceFiles'):'7z,aiff,asf,avi,bmp,csv,doc,fla,flv,gif,gz,gzip,jpeg,jpg,mid,mov,mp3,mp4,mpc,mpeg,mpg,ods,odt,pdf,png,ppt,pxd,qt,ram,rar,rm,rmi,rmvb,rtf,sdc,sitd,swf,sxc,sxw,tar,tgz,tif,tiff,txt,vsd,wav,wma,wmv,xls,zip',
		'deniedExtensions' => '');

$config['ResourceType'][] = Array(
		'name' => 'Images',
		'url' => ($session->get('CKFinderImagesUrl'))?$session->get('CKFinderImagesUrl'):$baseUrl . 'images',
		'directory' => ($session->get('CKFinderImagesPath'))?$session->get('CKFinderImagesPath'):$baseDir . 'images',
		'maxSize' => ($session->get('CKFinderMaxImagesSize'))?$session->get('CKFinderMaxImagesSize'):0,
		'allowedExtensions' =>($session->get('CKFinderResourceImages'))?$session->get('CKFinderResourceImages'):'bmp,gif,jpeg,jpg,png',
		'deniedExtensions' => '');

$config['ResourceType'][] = Array(
		'name' => 'Flash',
		'url' => ($session->get('CKFinderFlashUrl'))?$session->get('CKFinderFlashUrl'):$baseUrl . 'flash',
		'directory' => ($session->get('CKFinderFlashPath'))?$session->get('CKFinderFlashPath'):$baseDir . 'flash',
		'maxSize' => ($session->get('CKFinderMaxFlashSize'))?$session->get('CKFinderMaxFlashSize'):0,
		'allowedExtensions' =>($session->get('CKFinderResourceFlash'))?$session->get('CKFinderResourceFlash'):'swf,flv',
		'deniedExtensions' => '');

/*
Due to security issues with Apache modules, it is recommended to leave the
following setting enabled.

How does it work? Suppose the following:

- If "php" is on the denied extensions list, a file named foo.php cannot be
uploaded.
- If "rar" (or any other) extension is allowed, one can upload a file named
foo.rar.
- The file foo.php.rar has "rar" extension so, in theory, it can also be
uploaded.

In some conditions Apache can treat the foo.php.rar file just like any PHP
script and execute it.

If CheckDoubleExtension is enabled, each part of the file name after a dot is
checked, not only the last part. In this way uploading foo.php.rar would be
denied, because "php" is on the denied extensions list.
 */
$config['CheckDoubleExtension'] = true;

/*
If you have iconv enabled (visit http://php.net/iconv for more information),
you can use this directive to specify the encoding of file names in your
system. Acceptable values can be found at:
http://www.gnu.org/software/libiconv/

Examples:
$config['FilesystemEncoding'] = 'CP1250';
$config['FilesystemEncoding'] = 'ISO-8859-2';
 */
if (function_exists('iconv'))
{
	$config['FilesystemEncoding'] = iconv_get_encoding ('internal_encoding');
}
else {
	$config['FilesystemEncoding'] = 'UTF-8';
}

/*
Perform additional checks for image files
If set to true, validate image size.
 */
$config['SecureImageUploads'] = true;

/*
Indicates that the file size (maxSize) for images must be checked only
after scaling them. Otherwise, it is checked right after uploading.
 */
$config['CheckSizeAfterScaling'] = true;

/*
For security, HTML is allowed in the first Kb of data for files having the
following extensions only.
 */
$config['HtmlExtensions'] = array('html', 'htm', 'xml', 'js');

/*
Folders to not display in CKFinder, no matter what their location is.
No paths are accepted, only the folder name.
The * and ? wildcards are accepted.
 */
$config['HideFolders'] = Array(".svn", "CVS");

/*
Files to not display in CKFinder, no matter what their location is.
No paths are accepted, only the file name, including extension.
The * and ? wildcards are accepted.
 */
$config['HideFiles'] = Array(".*");

/*
After a file is uploaded, sometimes it is required to change its permissions
so that it was possible to access it at the later time.
If possible, it is recommended to set more restrictive permissions, like 0755.
Set to 0 to disable this feature.
Note: not needed on Windows-based servers.
 */
$config['ChmodFiles'] = 0755 ;

/*
See comments above.
Used when creating folders that do not exist.
 */
$config['ChmodFolders'] = 0755 ;

/*
Force ASCII names for files and folders.
If enabled, characters with diactric marks, like å, ä, ö, ć, č, đ, or š,
will automatically be converted to ASCII letters.
 */
$config['ForceAscii'] = false;

$plugins = $session->get('CKFinderSettingsPlugins');
if ($plugins['imageresize']) {
	include_once dirname(__FILE__).DS."plugins".DS."imageresize".DS."plugin.php";
}
if ($plugins['fileedit']) {
	include_once dirname(__FILE__).DS."plugins".DS."fileeditor".DS."plugin.php";
}

$config['plugin_imageresize']['smallThumb'] = '90x90';
$config['plugin_imageresize']['mediumThumb'] = '120x120';
$config['plugin_imageresize']['largeThumb'] = '180x180';