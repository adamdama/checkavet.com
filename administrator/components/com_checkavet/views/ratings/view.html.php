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
 * View class for a list of ratings.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_content
 * @since		1.6
 */
class CheckavetViewRatings extends JView
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
		JToolBarHelper::title(JText::_('COM_CHECKAVET_RATINGS_TITLE'), 'rating.png');

		//if ($canDo->get('core.create') || (count($user->getAuthorisedCategories('com_content', 'core.create'))) > 0 ) {
			JToolBarHelper::addNew('rating.add');
		//}

		//if (($canDo->get('core.edit'))/* || ($canDo->get('core.edit.own'))*/) {
			JToolBarHelper::editList('rating.edit');
		//}

		//if ($canDo->get('core.edit.state')) {
			JToolBarHelper::divider();
			JToolBarHelper::publish('ratings.publish', 'JTOOLBAR_PUBLISH', true);
			JToolBarHelper::unpublish('ratings.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			JToolBarHelper::divider();
			//JToolBarHelper::archiveList('ratings.archive');
			JToolBarHelper::checkin('ratings.checkin');
		//}

		if ($this->state->get('filter.state') == -2/* && $canDo->get('core.delete')*/) {
			JToolBarHelper::deleteList('', 'ratings.delete','JTOOLBAR_EMPTY_TRASH');
			JToolBarHelper::divider();
		}
		else /*if ($canDo->get('core.edit.state'))*/ {
			JToolBarHelper::trash('ratings.trash');
			JToolBarHelper::divider();
		}

		//if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_checkavet');
			JToolBarHelper::divider();
		//}

		//JToolBarHelper::help('JHELP_CONTENT_ARTICLE_MANAGER');
	}
}
