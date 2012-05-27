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
class CheckavetViewVets extends JView
{
	var $_limit = 10;
	
	var $vets;
	
	var $featured;
	
	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{		
		// Initialise some variables
		$app	= JFactory::getApplication();
		$pathway = $app->getPathway();
		$uri	= JFactory::getURI();	
		$params = $app->getParams();
		
		$this->vets = null;		
		$this->postcode = $this->get('Postcode');	
		
		// Get some data from the model
		$vets = $this->get('Vets');
		if($vets == null || count($vets) == 0)
			return parent::display($tpl);
		
		$vets = $this->limitVetList($vets);
		
		$tmp = array();
		foreach($vets as $key => $value)
		{
			foreach($value as $vet)
			{
				if(is_array($vet))
					array_push($tmp, $vet);
			}
		}		
		$this->vets = $tmp;	
		
		//separate featured vets
		$this->featured = array();
		for($i = 0; $i < count($this->vets); $i++)
		{
			$vet = $this->vets[$i];
			if($vet['featured'] == 1)
			{
				$move = array_splice($this->vets, $i, 1);
				array_push($this->featured, $move[0]);
				$i--;
			}
		}
		
		return parent::display($tpl);
	}
	
	function limitVetList($vets)
	{
		$tmp = array();
		$count = 0;
		
		foreach($vets as $postcodeArea)
		{
			array_push($tmp, $postcodeArea);
			$count += count($tmp);
			if($count > $this->_limit)
				break;
		}
		
		return $tmp;
	}
}
