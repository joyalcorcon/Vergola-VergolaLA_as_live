<?php
/**
 * @package		Joomla.Site
 * @subpackage	Application
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Joomla! Application define.
 */

//Global definitions.
//Joomla framework path definitions.
$parts = explode(DIRECTORY_SEPARATOR, JPATH_BASE);

//Defines.
define('JPATH_ROOT',			implode(DIRECTORY_SEPARATOR, $parts));

define('JPATH_SITE',			JPATH_ROOT);
define('JPATH_CONFIGURATION',	JPATH_ROOT);
define('JPATH_ADMINISTRATOR',	JPATH_ROOT . '/administrator');
define('JPATH_LIBRARIES',		JPATH_ROOT . '/libraries');
define('JPATH_PLUGINS',			JPATH_ROOT . '/plugins'  );
define('JPATH_INSTALLATION',	JPATH_ROOT . '/installation');
define('JPATH_THEMES',			JPATH_BASE . '/templates');
define('JPATH_CACHE',			JPATH_BASE . '/cache');
define('JPATH_MANIFESTS',		JPATH_ADMINISTRATOR . '/manifests');
define('IS_TEST_MODE',		'0');
define('HOST_SERVER',		'LA');
define('METRIC_SYSTEM',		'inch');  

 // define('SQL_DFORMAT',		'%d-%b-%y');
// define('PHP_DFORMAT',		'd-M-y');
// define('JS_DFORMAT',		'dd-M-yyyy');   

define('SQL_DFORMAT',               '%b-%d-%Y');
define('PHP_DFORMAT',               'd-M-Y');
define('JS_DFORMAT',                'dd-M-yyyy');  

define('SQL_DATE_FORMAT_01',        '%d-%b-%Y');
define('SQL_DATETIME_FORMAT_01',    '%d-%b-%Y @ %h:%i %p');

define('SQL_DFORMAT_21', '%Y-%m-%d');
