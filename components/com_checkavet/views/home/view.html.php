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
class CheckavetViewHome extends JView
{
	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		// this view will handle the sourcing of the swappable images
		
		
		if(JRequest::getString('feedbackEmail')){
			$data =new stdClass();
			$data->id = null;
			$data->email = JRequest::getString('feedbackEmail');
			
			$db = JFactory::getDBO();
			$db->insertObject( '#__email_signups', $data );
			
			$this->emailAdded = true;
		}
		
		parent::display($tpl);
	}
}
