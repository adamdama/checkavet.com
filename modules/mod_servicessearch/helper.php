<?php
/**
 * @version		$Id: helper.php 22338 2011-11-04 17:24:53Z github_bot $
 * @package		Joomla.Site
 * @subpackage	mod_search
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/**
 * @package		Joomla.Site
 * @subpackage	mod_search
 * @since		1.5
 */
class modServicessearchHelper
{
	
	public static function getServiceTypes()
	{
		require_once(JPATH_COMPONENT.DS.'models'.DS.'petservices.php');
		$model = new CheckavetModelPetservices();
		$serviceTypes = $model->getServiceTypes();
		
		return $serviceTypes;
	}
}
