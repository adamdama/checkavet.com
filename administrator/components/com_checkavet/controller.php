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
 * Checkavet master display controller.
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
	protected $default_view = 'vets';

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
		require_once JPATH_COMPONENT.'/helpers/checkavet.php';
		
		// Load the submenu.
		CheckavetHelper::addSubmenu(JRequest::getCmd('view', 'vets'));

		$view		= JRequest::getCmd('view', 'vets');
		$layout 	= JRequest::getCmd('layout', 'vets');
		$id			= JRequest::getInt('id');
		
		
		// Check for edit form.
		if ($view == 'vet' && $layout == 'edit' && !$this->checkEditId('com_checkavet.edit.vet', $id)) {
			// Somehow the person just went to the form - we don't allow that.
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_checkavet&view=vets', false));

			return false;
		}
				
		// Check for edit form.
		if ($view == 'petservice' && $layout == 'edit' && !$this->checkEditId('com_checkavet.edit.petservice', $id)) {
			// Somehow the person just went to the form - we don't allow that.
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_checkavet&view=petservices', false));

			return false;
		}
		
		parent::display();

		return $this;
	}
}
