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
class CheckavetViewPetservices extends JView
{
	var $_limit = 10;
	
	var $petservices;
	
	var $featured;
	
	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{		
		require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'checkavet.php';	
		
		// Initialise some variables
		$params = &JComponentHelper::getParams('com_checkavet');
		
		$this->petservices = null;		
		$this->postcode = $this->get('Postcode');	
		$this->petservice = $this->get('Petservice');	
		
		// Get some data from the model
		$petservices = $this->get('Petservices');
		if($petservices == null || count($petservices) == 0)
			return parent::display($tpl);
		
		$petservices = $this->limitPetservicesList($petservices);
		
		$tmp = array();
		foreach($petservices as $key => $value)
		{
			foreach($value as $petservice)
			{
				if(is_array($petservice))
					array_push($tmp, $petservice);
			}
		}		
		$this->petservices = $tmp;	
		
		//separate featured vets
		$this->featured = array();
		for($i = 0; $i < count($this->petservices); $i++)
		{
			$petservice = &$this->petservices[$i];
			$petservice['rating'] = CheckavetHelper::createRater($petservice['id'], 'petservices', $params->get('max_rating'));
			if($petservice['featured'] == 1)
			{
				$move = array_splice($this->petservices, $i, 1);
				array_push($this->featured, $move[0]);
				$i--;
			}
		}
				
		return parent::display($tpl);
	}
	
	function limitPetservicesList($petservices)
	{
		$tmp = array();
		$count = 0;
		
		foreach($petservices as $postcodeArea)
		{
			array_push($tmp, $postcodeArea);
			$count += count($tmp);
			if($count > $this->_limit)
				break;
		}
		
		return $tmp;
	}
}
