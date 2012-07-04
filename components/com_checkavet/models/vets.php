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
class CheckavetModelVets extends JModel
{
	/**
	 * 
	 *
	 * @var array
	 */
	var $_vets = null;
	/**
	 * 
	 *
	 * @var string
	 */
	var $_postcode = null;
	/**
	 * 
	 *
	 * @var bool
	 */
	var $_emergency = false;

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
		$emergency		= JRequest::getBool('emergency');
		
		$this->setSearch($postcode, $emergency);
	}
	
	protected function setSearch($postcode, $emergency)
	{
		if($postcode === null || $postcode === "")
			return;
			
		$this->_postcode = $postcode;
		$this->_emergency = $emergency;
		
		$this->getVets();
	}
	
	
	function getPostcode()
	{
		return $this->_postcode;
	}

	/**
	 * 
	 *
	 * @access public
	 * @return array
	 */
	function getVets()
	{		
		// Lets load the content if it doesn't already exist
		if (empty($this->_vets))
		{			
			if($this->_postcode === null)
				return null;
				
			//search code						
			$db	= JFactory::getDbo();
			
			$where = null;
			
			if($this->_emergency)
				$where = $db->nameQuote('24hour')." = ".$db->quote('1').' AND ';
						
			$query = $db->getQuery(true);
			$query->clear();
			$query->select('*');
			$query->from($db->nameQuote('#__checkavet_vets').' AS '.$db->nameQuote('v'));
			$query->where($where.$db->nameQuote('state').' = 1');
			$db->setQuery($query);
			
			$vets = $db->loadAssocList();
			$this->_vets = $vets;
			if($this->_vets == null || count($this->_vets) == 0)
				return $this->_vets = null;
			
			$vets = CheckavetHelper::groupResultsByPostcode($vets);			
			$vets = CheckavetHelper::sortByDistance($this->_postcode, $vets);
			
			$this->_vets = $vets;
		}

		return $this->_vets;
	}

    public function storeVote($pk = 0, $rate = 0, $email = '', $name = '')
    {
    	$max = $params->get('max_rating');
		
        if ( $rate >= 1 && $rate <= $max && $pk > 0 )
        {
            $userIP = $_SERVER['REMOTE_ADDR'];
            $db = $this->getDbo();

            $db->setQuery(
                    'SELECT *' .
                    ' FROM #__content_rating' .
                    ' WHERE content_id = '.(int) $pk
            );

            $rating = $db->loadObject();

            if (!$rating)
            {
                // There are no ratings yet, so lets insert our rating
                $db->setQuery(
                        'INSERT INTO #__content_rating ( content_id, lastip, rating_sum, rating_count )' .
                        ' VALUES ( '.(int) $pk.', '.$db->Quote($userIP).', '.(int) $rate.', 1 )'
                );

                if (!$db->query()) {
                        $this->setError($db->getErrorMsg());
                        return false;
                }
            } else {
                if ($userIP != ($rating->lastip))
                {
                    $db->setQuery(
                            'UPDATE #__content_rating' .
                            ' SET rating_count = rating_count + 1, rating_sum = rating_sum + '.(int) $rate.', lastip = '.$db->Quote($userIP) .
                            ' WHERE content_id = '.(int) $pk
                    );
                    if (!$db->query()) {
                            $this->setError($db->getErrorMsg());
                            return false;
                    }
                } else {
                    return false;
                }
            }
            return true;
        }
        JError::raiseWarning( 'SOME_ERROR_CODE', JText::sprintf('COM_CONTENT_INVALID_RATING', $rate), "JModelArticle::storeVote($rate)");
        return false;
    }
}
