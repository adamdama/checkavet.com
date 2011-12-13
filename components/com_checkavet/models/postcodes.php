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
class CheckavetModelPostcodes extends JModel
{
	var $_postcodes = null;
	
	/**
	 * Constructor
	 *
	 * @since 1.5
	 */
	function __construct()
	{		
		parent::__construct();
				
		$db	= JFactory::getDbo();	
		
		$query = $db->getQuery(true);
		$query->clear();
		$query->select($db->nameQuote('p.id').', '.$db->nameQuote('p.postcode').' AS '.$db->nameQuote('postcode').', '.$db->nameQuote('p.latitude').' AS '.$db->nameQuote('lat').', '.$db->nameQuote('p.longitude').' AS '.$db->nameQuote('long'));
		$query->from('#__uk_postcodes AS p');	
		$db->setQuery($query);
		
		$this->_postcodes = $db->loadAssocList('postcode');	
	}
	
	public function getPostcodes()
	{
		return $this->_postcodes;
	}

}