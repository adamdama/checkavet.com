<?php
/**
 * @version		$Id: mod_search.php 21597 2011-06-21 13:14:15Z chdemko $
 * @package		Joomla.Site
 * @subpackage	mod_search
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

$label = htmlspecialchars($params->get('label', JText::_('MOD_VETSEARCH_LABEL_TEXT')));

$para1 = $params->get('paragraph1');
$para2 = $params->get('paragraph2');

$mitemid = JRequest::getInt('Itemid');

require JModuleHelper::getLayoutPath('mod_vetsearch', $params->get('layout', 'default'));