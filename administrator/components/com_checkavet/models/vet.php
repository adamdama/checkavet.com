<?php
/**
 * @version		$Id: vet.php 22355 2011-11-07 05:11:58Z github_bot $
 * @package		Joomla.Administrator
 * @subpackage	com_checkavet
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

require_once JPATH_COMPONENT_ADMINISTRATOR.'/helpers/checkavet.php';

/**
 * Item Model for an Vet.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_checkavet
 * @since		1.6
 */
class CheckavetModelVet extends JModelAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_CHECKAVET';

	/**
	 * Prepare and sanitise the table data prior to saving.
	 *
	 * @param	JTable	A JTable object.
	 *
	 * @return	void
	 * @since	1.6
	 */
	protected function prepareTable(&$table)
	{
		// Set the publish date to now
		if($table->state == 1 && intval($table->publish_up) == 0) {
			$table->publish_up = JFactory::getDate()->toMySQL();
		}

		// Increment the content version number.
		$table->version++;

		// Reorder the vets within the category so the new vet is first
		if (empty($table->id)) {
			$table->reorder('state >= 0');
		}
	}

	/**
	 * Returns a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 *
	 * @return	JTable	A database object
	*/
	public function getTable($type = 'Vets', $prefix = 'JTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get a single record.
	 *
	 * @param	integer	The id of the primary key.
	 *
	 * @return	mixed	Object on success, false on failure.
	 */
	public function getItem($pk = null)
	{
		if ($item = parent::getItem($pk)) {
			// Convert the params field to an array.
			/*$registry = new JRegistry;
			$registry->loadString($item->attribs);
			$item->attribs = $registry->toArray();

			// Convert the params field to an array.
			$registry = new JRegistry;
			$registry->loadString($item->metadata);
			$item->metadata = $registry->toArray();*/

			//$item->vettext = trim($item->fulltext) != '' ? $item->introtext . "<hr id=\"system-readmore\" />" . $item->fulltext : $item->introtext;
		}

		return $item;
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 *
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_checkavet.vet', 'vet', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		// Determine correct permissions to check.
		/*if ($id = (int) $this->getState('vet.id')) {
			// Existing record. Can only edit in selected categories.
			$form->setFieldAttribute('catid', 'action', 'core.edit');
			// Existing record. Can only edit own vets in selected categories.
			$form->setFieldAttribute('catid', 'action', 'core.edit.own');
		}
		else {*/
			// New record. Can only create in selected categories.
			//$form->setFieldAttribute('catid', 'action', 'core.create');
		//}

		// Modify the form based on Edit State access controls.
		/*if (!$this->canEditState((object) $data)) {
			// Disable fields for display.
			$form->setFieldAttribute('featured', 'disabled', 'true');
			$form->setFieldAttribute('ordering', 'disabled', 'true');
			$form->setFieldAttribute('publish_up', 'disabled', 'true');
			$form->setFieldAttribute('publish_down', 'disabled', 'true');
			$form->setFieldAttribute('state', 'disabled', 'true');

			// Disable fields while saving.
			// The controller has already verified this is an vet you can edit.
			$form->setFieldAttribute('featured', 'filter', 'unset');
			$form->setFieldAttribute('ordering', 'filter', 'unset');
			$form->setFieldAttribute('publish_up', 'filter', 'unset');
			$form->setFieldAttribute('publish_down', 'filter', 'unset');
			$form->setFieldAttribute('state', 'filter', 'unset');
		}*/

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_checkavet.edit.vet.data', array());

		if (empty($data)) {
			$data = $this->getItem();

			// Prime some default values.
			//if ($this->getState('vet.id') == 0) {
			//	$app = JFactory::getApplication();
			//	$data->set('catid', JRequest::getInt('catid', $app->getUserState('com_checkavet.vets.filter.category_id')));
			//}
		}

		return $data;
	}

	/**
	 * Method to save the form data.
	 *
	 * @param	array	The form data.
	 *
	 * @return	boolean	True on success.
	 * @since	1.6
	 */
	public function save($data)
	{
		// Alter the title for save as copy
		if (JRequest::getVar('task') == 'save2copy') {
			//list($title,$alias) = $this->generateNewTitle($data['catid'], $data['alias'], $data['title']);
			//$data['title']	= $title;
			//$data['alias']	= $alias;
		}

		if (parent::save($data)) {
			//if (isset($data['featured'])) {
			//	$this->featured($this->getState($this->getName().'.id'), $data['featured']);
			//}
			return true;
		}

		return false;
	}

	/**
	 * Method to toggle the featured setting of vets.
	 *
	 * @param	array	The ids of the items to toggle.
	 * @param	int		The value to toggle to.
	 *
	 * @return	boolean	True on success.
	 */
	public function featured($pks, $value = 0)
	{
		// Sanitize the ids.
		$pks = (array) $pks;
		/*JArrayHelper::toInteger($pks);

		if (empty($pks)) {
			$this->setError(JText::_('COM_CHECKAVET_NO_ITEM_SELECTED'));
			return false;
		}

		$table = $this->getTable('Featured', 'CheckavetTable');

		try {
			$db = $this->getDbo();

			$db->setQuery(
				'UPDATE #__vets AS v' .
				' SET v.featured = '.(int) $value.
				' WHERE v.id IN ('.implode(',', $pks).')'
			);
			if (!$db->query()) {
				throw new Exception($db->getErrorMsg());
			}

			if ((int)$value == 0) {
				// Adjust the mapping table.
				// Clear the existing features settings.
				$db->setQuery(
					'DELETE FROM #__vets_frontpage' .
					' WHERE content_id IN ('.implode(',', $pks).')'
				);
				if (!$db->query()) {
					throw new Exception($db->getErrorMsg());
				}
			} else {
				// first, we find out which of our new featured vets are already featured.
				$query = $db->getQuery(true);
				$query->select('f.content_id');
				$query->from('#__vets_frontpage AS f');
				$query->where('content_id IN ('.implode(',', $pks).')');
				//echo $query;
				$db->setQuery($query);

				if (!is_array($old_featured = $db->loadResultArray())) {
					throw new Exception($db->getErrorMsg());
				}

				// we diff the arrays to get a list of the vets that are newly featured
				$new_featured = array_diff($pks, $old_featured);

				// Featuring.
				$tuples = array();
				foreach ($new_featured as $pk) {
					$tuples[] = '('.$pk.', 0)';
				}
				if (count($tuples)) {
					$db->setQuery(
						'INSERT INTO #__vets_frontpage (`content_id`, `ordering`)' .
						' VALUES '.implode(',', $tuples)
					);
					if (!$db->query()) {
						$this->setError($db->getErrorMsg());
						return false;
					}
				}
			}

		} catch (Exception $e) {
			$this->setError($e->getMessage());
			return false;
		}

		$table->reorder();

		$this->cleanCache();*/

		return true;
	}

	/**
	 * A protected method to get a set of ordering conditions.
	 *
	 * @param	object	A record object.
	 *
	 * @return	array	An array of conditions to add to add to ordering queries.
	 * @since	1.6
	 */
	protected function getReorderConditions($table)
	{
		$condition = array();
		//$condition[] = 'catid = '.(int) $table->catid;
		return $condition;
	}

	/**
	 * Custom clean the cache of com_checkavet and content modules
	 *
	 * @since	1.6
	 */
	protected function cleanCache()
	{
		parent::cleanCache('com_checkavet');
		//parent::cleanCache('mod_vets_archive');
		//parent::cleanCache('mod_vets_categories');
		//parent::cleanCache('mod_vets_category');
		//parent::cleanCache('mod_vets_latest');
		//parent::cleanCache('mod_vets_news');
		//parent::cleanCache('mod_vets_popular');
	}
}
