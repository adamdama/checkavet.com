<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

// Base this model on the backend version.
require_once JPATH_ADMINISTRATOR.'/components/com_checkavet/models/rating.php';

/**
 * Content Component Article Model
 *
 * @package		Joomla.Site
 * @subpackage	com_content
 * @since 1.5
 */
 
class CheckavetModelRate extends CheckavetModelRating
{
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication();

		// Load state from the request.
		$pk = JRequest::getInt('id');
		$this->setState('rating.id', $pk);

		$return = JRequest::getVar('return', null, 'default', 'base64');
		$this->setState('return_page', base64_decode($return));

		// Load the parameters.
		$params	= $app->getParams();
		$this->setState('params', $params);

		$this->setState('layout', JRequest::getCmd('layout'));
	}

	/**
	 * Method to get rating data.
	 *
	 * @param	integer	The id of the rating.
	 *
	 * @return	mixed	Content item data object on success, false on failure.
	 */
	public function getItem($itemId = null)
	{
		// Initialise variables.
		$itemId = $this->getState('rating.id');

		// Get a row instance.
		$table = $this->getTable();

		// Attempt to load the row.
		$return = $table->load($itemId);

		// Check for a table object error.
		if ($return === false && $table->getError()) {
			$this->setError($table->getError());
			return false;
		}

		$properties = $table->getProperties(1);
		$value = JArrayHelper::toObject($properties, 'JObject');

		// Compute selected asset permissions.
		$user	= JFactory::getUser();
		$userId	= $user->get('id');
		$asset	= 'com_content.rating.'.$value->id;

		return $value;
	}

	/**
	 * Get the return URL.
	 *
	 * @return	string	The return URL.
	 * @since	1.6
	 */
	public function getReturnPage()
	{
		return base64_encode($this->getState('return_page'));
	}
	

    public function storeVote($obj_id = 0, $rate = 0, $email = '', $name = '', $rating_text = '')
    {
    	$max = JComponentHelper::getParams('com_checkavet')->get('max_rating');

        if ( $rate > 0 && $rate <= $max && $obj_id > 0  && $email != '')
        {
    		$user =& JFactory::getUser(JUserHelper::getUserId($email));

			if($user->id == 0)
			{				
				if(!$user = $this->createUser($email, $name))
				{	
					$this->setError(JText::_('COM_CHECKAVET_ERROR_USER_CREATE'));
					
                	return false;
				}
			}
			
        	$rate /= $max;
			
            $db = $this->getDbo();

            $db->setQuery('SELECT `id` FROM `#__checkavet_ratings` WHERE `email` = '.$email);
            $rated = $db->loadObject();

            if (!$rated)
            {
            	$date =& JFactory::getDate();
                $db->setQuery('INSERT INTO `#__checkavet_ratings` ( `obj_id`, `obj_table`, `name`, `email`, `rating`,`ratingtext`, `state`, `created`, `created_by` )' .
                        		' VALUES ( '.(int) $obj_id.', '.$db->quote('vets').', '.$db->quote($name).', '.$db->quote($email).', '.$rate.', '.$db->quote($rating_text).', 1, '.$db->quote($date->toMySQL()).', '.$user->id.')');

                if (!$db->query())
                {
                    $this->setError($db->getErrorMsg());
                	return false;
                }
            } 
			
            return true;
        }
		
        JError::raiseWarning( 'CHECKAVET_FAILED_VOTE', JText::sprintf('COM_CHECKAVET_INVALID_RATING', $rate), "JModelVets::storeVote($rate)");
		
        return false;
	}

	function createUser($email, $name = '')
	{
		if(!$email)
			return false;
		
		$user = clone(JFactory::getUser());
		$authorize = & JFactory::getACL();
		$userGroup = 'Registered';

		$data = array();
		$user->set('name', $name ? $name : $email);
		$user->set('username', $email); 
		$user->set('email', $email);
		$user->set('usertype', $userGroup);		
		$user->set('id', 0);
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('g.id AS gid')
				->from('#__usergroups AS g')
				->where('g.title = '.$db->quote($userGroup));
		$db->setQuery($query);
		$grp = $db->loadObject();
		
		$gid = $grp->gid ? $grp->gid : 2;		
		$user->set('gid', $gid);
		
		$date =& JFactory::getDate();
		$user->set('registerDate', $date->toMySQL());
		
		if($user->save())
		{
			$query = $db->getQuery(true);
			$query->insert('#__user_usergroup_map');
			$query->set('user_id = '.$user->id.', group_id = '.$user->gid);
			$db->setQuery($query)->query();
			return $user;
		}
		
		$this->setError($user->getError());
		
		return false;
	}
}
