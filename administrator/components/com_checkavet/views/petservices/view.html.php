<?php
/**
 * @version		$Id: view.html.php 22355 2011-11-07 05:11:58Z github_bot $
 * @package		Joomla.Administrator
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of petservices.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_content
 * @since		1.6
 */
class CheckavetViewPetservices extends JView
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 *
	 * @return	void
	 */
	public function display($tpl = null)
	{
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal') {
			$this->addToolbar();
		}

		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		//$canDo	= ContentHelper::getActions($this->state->get('filter.category_id'));
		$user		= JFactory::getUser();
		JToolBarHelper::title(JText::_('COM_CHECKAVET_PETSERVICES_TITLE'), 'petservice.png');

		//if ($canDo->get('core.create') || (count($user->getAuthorisedCategories('com_content', 'core.create'))) > 0 ) {
			JToolBarHelper::addNew('petservice.add');
		//}

		//if (($canDo->get('core.edit'))/* || ($canDo->get('core.edit.own'))*/) {
			JToolBarHelper::editList('petservice.edit');
		//}

		//if ($canDo->get('core.edit.state')) {
			JToolBarHelper::divider();
			JToolBarHelper::publish('petservices.publish', 'JTOOLBAR_PUBLISH', true);
			JToolBarHelper::unpublish('petservices.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			JToolBarHelper::custom('petservices.featured', 'featured.png', 'featured_f2.png', 'JFEATURED', true);
			JToolBarHelper::divider();
			//JToolBarHelper::archiveList('petservices.archive');
			JToolBarHelper::checkin('petservices.checkin');
		//}

		if ($this->state->get('filter.state') == -2/* && $canDo->get('core.delete')*/) {
			JToolBarHelper::deleteList('', 'petservices.delete','JTOOLBAR_EMPTY_TRASH');
			JToolBarHelper::divider();
		}
		else /*if ($canDo->get('core.edit.state'))*/ {
			JToolBarHelper::trash('petservices.trash');
			JToolBarHelper::divider();
		}

		//if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_checkavet');
			JToolBarHelper::divider();
		//}

		//JToolBarHelper::help('JHELP_CONTENT_ARTICLE_MANAGER');
	}
}
