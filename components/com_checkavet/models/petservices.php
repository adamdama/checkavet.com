<?php
/**
 * @version		$Id: search.php 22338 2011-11-04 17:24:53Z github_bot $
 * @package		Joomla.Site
 * @subpackage	com_search
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.model');

/**
 * Search Component Search Model
 *
 * @package		Joomla.Site
 * @subpackage	com_search
 * @since 1.5
 */
class CheckavetModelPetservices extends JModel
{
	/**
	 * 
	 *
	 * @var array
	 */
	var $_services = null;
	/**
	 * 
	 *
	 * @var string
	 */
	var $_postcode = null;
	/**
	 * 
	 *
	 * @var string
	 */
	var $_type = false;

	/**
	 * Constructor
	 *
	 * @since 1.5
	 */
	function __construct()
	{
		parent::__construct();
		
		require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'checkavet.php';
		
		// Set the search parameters
		$postcode		= strtoupper(JRequest::getString('postcode'));
		$servicetype	= JRequest::getString('servicetype');
		
		$this->setSearch($postcode, $servicetype);
	}
	
	protected function setSearch($postcode, $servicetype)
	{
		if($postcode === null || $postcode === "")
			return;
			
		$this->_postcode = $postcode;
		$this->_type = $servicetype;
		
		$this->getPetservices();
	}
	
	
	function getPostcode()
	{
		return $this->_postcode;
	}
	
	
	function getPetservice()
	{
		return $this->_type;
	}

	/**
	 * 
	 *
	 * @access public
	 * @return array
	 */
	function getPetservices()
	{		
		// Lets load the content if it doesn't already exist
		if (empty($this->_services))
		{			
			if($this->_postcode === null)
				return null;
				
			//search code						
			$db	= JFactory::getDbo();
						
			$query = $db->getQuery(true);
			$query->clear();
			$query->select('*');
			$query->from($db->nameQuote('#__petservices').' AS '.$db->nameQuote('s'));
			$query->where($db->nameQuote('state').' = 1 AND '.$db->nameQuote('industry').' = '.$db->quote($this->_type));
			$db->setQuery($query);
			
			$services = $db->loadAssocList();
			$this->_services = $services;
			if($this->_services == null || count($this->_services) == 0)
				return $this->_services = null;
			
			$services = CheckavetHelper::groupResultsByPostcode($services);			
			$services = CheckavetHelper::sortByDistance($this->_postcode, $services);
			
			$this->_services = $services;
		}

		return $this->_services;
	}
	
	function getServiceTypes()
	{		
		$db	= JFactory::getDbo();
		
		$query = $db->getQuery(true);
		$query->clear();
		$query->select($db->nameQuote('s.industry').' AS '.$db->nameQuote('servicetype'));
		$query->from($db->nameQuote('#__petservices').' AS '.$db->nameQuote('s'));
		$query->where($db->nameQuote('state').' = 1');
		$db->setQuery($query);
		
		$tmp = array();
		$services = $db->loadAssocList();
		
		foreach($services as $service)
		{
			if(!in_array($service['servicetype'], $tmp))
			{
				array_push($tmp, $service['servicetype']);
			}
		}
		
		return $tmp;
	}
}
