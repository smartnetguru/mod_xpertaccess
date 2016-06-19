<?php
/**
 * @package XpertAccess
 * @version 3.2
 * @author ThemeXpert http://www.themexpert.com
 * @copyright Copyright (C) 2009 - 2011 ThemeXpert
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

$params->def('greeting', 1);

$type	= modXpertAccessHelper::getType();
$return	= modXpertAccessHelper::getReturnURL($params, $type);
$user	= JFactory::getUser();

modXpertAccessHelper::loadScripts($params);
modXpertAccessHelper::loadStyles($params);

require JModuleHelper::getLayoutPath('mod_xpertaccess', $params->get('layout', 'default'));