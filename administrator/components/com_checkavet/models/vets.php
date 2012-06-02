<?php
/**
 * @version		$Id: articles.php 22355 2011-11-07 05:11:58Z github_bot $
 * @package		Joomla.Administrator
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of article records.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_content
 */
class CheckavetModelVets extends JModelList
{
	/**
	 * Constructor.
	 *
	 * @param	array	An optional associative array of configuration settings.
	 * @see		JController
	 * @since	1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'v.id',
				'name', 'v.name',
				'county', 'v.county',
				'town', 'v.town',
				'checked_out', 'v.checked_out',
				'checked_out_time', 'v.checked_out_time',
				'accredited', 'v.accredited',
				'state', 'v.state',
				'access', 'v.access', 'access_level',
				'created', 'v.created',
				'created_by', 'v.created_by',
				'ordering', 'v.ordering',
				'featured', 'v.featured',
				'language', 'v.language',
				'hits', 'v.hits',
				'publish_up', 'v.publish_up',
				'publish_down', 'v.publish_down',
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return	void
	 * @since	1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication();
		$session = JFactory::getSession();

		// Adjust the context to support modal layouts.
		if ($layout = JRequest::getVar('layout')) {
			$this->context .= '.'.$layout;
		}

		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$access = $this->getUserStateFromRequest($this->context.'.filter.access', 'filter_access', 0, 'int');
		$this->setState('filter.access', $access);

		$state = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '');
		$this->setState('filter.state', $state);

		$county = $this->getUserStateFromRequest($this->context.'.filter.county', 'filter_county', '');
		$this->setState('filter.county', $county);

		$town = $this->getUserStateFromRequest($this->context.'.filter.town', 'filter_town', '');
		$this->setState('filter.town', $town);

		// List state information.
		parent::populateState('v.id', 'desc');
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param	string		$id	A prefix for the store id.
	 *
	 * @return	string		A store id.
	 * @since	1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('filter.search');
		$id	.= ':'.$this->getState('filter.access');
		$id	.= ':'.$this->getState('filter.state');
		//$id	.= ':'.$this->getState('filter.county');
		//$id	.= ':'.$this->getState('filter.town');

		return parent::getStoreId($id);
	}

	/**
	 * Build an SQL query to load the list datv.
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		$user	= JFactory::getUser();

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'v.id, v.name, v.county, v.town, v.phone, v.email, v.website, v.checked_out, v.checked_out_time' .
				', v.state, v.access, v.created, v.ordering, v.featured, v.hits' .
				', v.publish_up, v.publish_down'
			)
		);
		$query->from('#__vets AS v');

		// Join over the users for the checked out user.
		$query->select('uc.name AS editor');
		$query->join('LEFT', '#__users AS uc ON uc.id = v.checked_out');

		// Join over the asset groups.
		//$query->select('ag.title AS access_level');
		//$query->join('LEFT', '#__viewlevels AS vg ON ag.id = v.access');

		// Filter by access level.
		if ($access = $this->getState('filter.access')) {
			$query->where('v.access = ' . (int) $access);
		}

		// Implement View Level Access
		if (!$user->authorise('core.admin'))
		{
		    $groups	= implode(',', $user->getAuthorisedViewLevels());
			$query->where('v.access IN ('.$groups.')');
		}

		// Filter by state
		$state = $this->getState('filter.state');
		if (is_numeric($state)) {
			$query->where('v.state = ' . (int) $state);
		}
		elseif ($state === '') {
			$query->where('(v.state = 0 OR v.state = 1)');
		}

		// Filter by county
		$county = $this->getState('filter.county');
		$county = $county === '' ? false : $county;
		if ($county) {
			$query->where('v.county = ' . $db->Quote($county));
		}

		// Filter by town
		$town = $this->getState('filter.town');
		$town = $town === '' ? false : $town;
		if ($town) {
			$query->where('v.town = ' . $db->Quote($town));
		}

		// Filter by a single or group of categories.
		//$categoryId = $this->getState('filter.category_id');
		//if (is_numeric($categoryId)) {
		//	$query->where('v.catid = '.(int) $categoryId);
		//}
		//elseif (is_array($categoryId)) {
		//	JArrayHelper::toInteger($categoryId);
		//	$categoryId = implode(',', $categoryId);
		//	$query->where('v.catid IN ('.$categoryId.')');
		//}

		// Filter by author
		//$authorId = $this->getState('filter.author_id');
		//if (is_numeric($authorId)) {
		//	$type = $this->getState('filter.author_id.include', true) ? '= ' : '<>';
		//	$query->where('v.created_by '.$type.(int) $authorId);
		//}

		// Filter by search in title.
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('v.id = '.(int) substr($search, 3));
			}
			/*elseif (stripos($search, 'author:') === 0) {
				$search = $db->Quote('%'.$db->getEscaped(substr($search, 7), true).'%');
				$query->where('(uv.name LIKE '.$search.' OR uv.username LIKE '.$search.')');
			}*/
			else {
				$search = $db->Quote('%'.$db->getEscaped($search, true).'%');
				$query->where('(v.name LIKE '.$search.' OR v.address1 LIKE '.$search.')');
			}
		}

		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering');
		$orderDirn	= $this->state->get('list.direction');
		//if ($orderCol == 'v.ordering' || $orderCol == 'category_title') {
		//	$orderCol = 'category_title '.$orderDirn.', v.ordering';
		//}
		$query->order($db->getEscaped($orderCol.' '.$orderDirn));

		// echo nl2br(str_replace('#__','jos_',$query));
		return $query;
	}

	/**
	 * Build a list of counties
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */	 
	public function getOptionCounties() {
		$db		= $this->getDbo();
		// Select the required fields from the table.
		//$query = "SELECT DISTINCT `county` FROM `#__vets` WHERE `county` <> ''";
		$query = "SELECT DISTINCT `county` FROM `#__vets`";
		$db->setQuery($query);
		$results = $db->loadResultArray();
		sort($results);
		//put in assoc for values in the option tags
		$assoc = array();
		foreach($results as $result)
			$assoc[$result] = $result;
		
		return $assoc;
	}

	/**
	 * Build a list of towns
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */	 
	public function getOptionTowns() {
		$db		= $this->getDbo();
		// Select the required fields from the table.
		//$query = "SELECT DISTINCT `county` FROM `#__vets` WHERE `county` <> ''";
		$query = "SELECT DISTINCT `town` FROM `#__vets`";
		$db->setQuery($query);
		$results = $db->loadResultArray();
		sort($results);
		//put in assoc for values in the option tags
		$assoc = array();
		foreach($results as $result)
			$assoc[$result] = $result;
		
		return $assoc;
	}

	/**
	 * Method to get a list of articles.
	 * Overridden to add a check for access levels.
	 *
	 * @return	mixed	An array of data items on success, false on failure.
	 * @since	1.6.1
	 */
	public function getItems()
	{
		$items	= parent::getItems();
		$app	= JFactory::getApplication();
		if ($app->isSite()) {
			$user	= JFactory::getUser();
			$groups	= $user->getAuthorisedViewLevels();

			for ($x = 0, $count = count($items); $x < $count; $x++) {
				//Check the access level. Remove articles the user shouldn't see
				if (!in_array($items[$x]->access, $groups)) {
					unset($items[$x]);
				}
			}
		}
		return $items;
	}
}
