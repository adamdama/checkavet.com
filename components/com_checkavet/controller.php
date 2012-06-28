<?php
/**
 * @version		$Id: controller.php 22338 2011-11-04 17:24:53Z github_bot $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Checkavet master display controller. sets up variables and sends to correct place.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_checkavet
 * @since		1.6
 */
class CheckavetController extends JController
{
	/**
	 * @var		string	The default view.
	 * @since	1.6
	 */
	protected $default_view = 'home';

	/**
	 * Method to display a view.
	 *
	 * @param	boolean			If true, the view output will be cached
	 * @param	array			An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{

		$user = JFactory::getUser();

		if ($user->get('id')) {
			$cachable = false;
		}
		
		$vName	= JRequest::getCmd('view', 'home');
		JRequest::setVar('view', $vName);

		return parent::display($cachable, $urlparams);
	}
	/*
	function vets($cachable = false, $urlparams = false)
	{	
		$post = JRequest::get();	
		$postcode = $post['postcode'];

		$id		= JRequest::getInt('a_id');
		$vName	= JRequest::getCmd('view', 'vets');
		
		echo $vName;
		exit();
		JRequest::setVar('view', $vName);
				
   		parent::display($cachable, $urlparams);
	}
	
	function petservices($cachable = false, $urlparams = false)
	{	
		$post = JRequest::get();	
		$postcode = $post['postcode'];

		$id		= JRequest::getInt('a_id');
		$vName	= JRequest::getCmd('view', 'vets');
		
		echo $vName;
		exit();
		JRequest::setVar('view', $vName);		
		
   		parent::display($cachable, $urlparams);
	}*/
}
