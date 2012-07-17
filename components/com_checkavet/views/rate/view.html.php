<?php
/**
 * @version		$Id: view.html.php 22338 2011-11-04 17:24:53Z github_bot $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of checkavet terms.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_checkavet
 * @since		1.5
 */
class CheckavetViewRate extends JView
{
	protected $form;
	protected $item;
	protected $return_page;
	protected $state;

	public function display($tpl = null)
	{		
		// Initialise variables.
		$app		= JFactory::getApplication();
		$user		= JFactory::getUser();

		// Get model data.
		$this->state		= $this->get('State');
		$this->item			= $this->get('Item');
		$this->form			= $this->get('Form');
		$this->return_page	= $this->get('ReturnPage');

		if (!empty($this->item) && isset($this->item->id)) {
			$this->item->images = json_decode($this->item->images);
			$this->item->urls = json_decode($this->item->urls);

			$this->form->bind($this->item);
			$this->form->bind($this->item->urls);
			$this->form->bind($this->item->images);

		}

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseWarning(500, implode("\n", $errors));
			return false;
		}

		// Create a shortcut to the parameters.
		$params	= &$this->state->params;

		$this->params	= $params;
		$this->user		= $user;
		$this->max_rating = $params->get('max_rating');
		
		$this->rating = JRequest::getVar('user_rating', 0);
		
		//$this->_prepareDocument();
		parent::display($tpl);
	}
}
