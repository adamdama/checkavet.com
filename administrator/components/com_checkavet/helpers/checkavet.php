<?php
/**
 * @version     $Id: search.php 22359 2011-11-07 16:31:03Z github_bot $
 * @copyright   Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Search component helper.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_search
 */
class CheckavetHelper
{
    public static $extension = 'com_content';
    
    const POSTCODE_AREA_REGEXP = "/[A-Z]{1,2}[0-9R][0-9A-Z]?/";
    
    const VALID_POSTCODE_REGEXP = "/^(([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([A-Za-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9]?[A-Za-z])))) [0-9][A-Za-z]{2}))$/";
    
    public static function postcodeAreaRegexp()
    {
        return self::POSTCODE_AREA_REGEXP;
    }
    
    public static function validPostcodeRegexp()
    {
        return self::VALID_POSTCODE_REGEXP;
    }
    
    /**
     * Gets a list of the actions that can be performed.
     *
     * @return  JObject
     */
    public static function getActions()
    {
        $user      = JFactory::getUser();
        $result    = new JObject;
        $assetName = 'com_checkavet';
        
        $actions = array(
            'core.admin',
            'core.manage',
            'core.create',
            'core.edit',
            'core.edit.state',
            'core.delete'
        );
        
        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }
        
        return $result;
    }
    
    public static function groupResultsByPostcode($results)
    {
        if ($results == null)
            return;
        
        $grouped = array();
        
        foreach ($results as $result) {
            if (!self::validateUKPostcode($result['postcode']))
                continue;
            
            $postcodeArea = CheckavetHelper::getPostcodeArea($result['postcode']);
            if (!$postcodeArea)
                continue;
            
            if (!isset($grouped[$postcodeArea]))
                $grouped[$postcodeArea] = array();
            
            array_push($grouped[$postcodeArea], $result);
        }
        
        return $grouped;
    }
    
    public static function getPostcodeArea($postcode)
    {
        preg_match(self::POSTCODE_AREA_REGEXP, strtoupper($postcode), $match);
        if (count($match) == 0)
            return false;
        
        $postcodeArea = $match[0];
        
        return $postcodeArea;
    }
    
    public static function sortByDistance($postcode, $data)
    {
        require_once(JPATH_COMPONENT_ADMINISTRATOR . DS . 'models' . DS . 'postcodes.php');
        $model     = new CheckavetModelPostcodes();
        $postcodes = $model->getPostcodes();
		        
        $homePos = self::geocodePostCode($postcode);
        if(!$homePos)
            return $data;

        $homeLat      = $homePos[0];
        //echo $homeLat.", ";
        $homeLng      = $homePos[1];
        //echo $homeLng;
        
        foreach ($data as $key => $value) {
            $pa   = self::getPostcodeArea($key);
            $lat  = $postcodes[$pa]['lat'];
            $lng = $postcodes[$pa]['lng'];
            
            $data[$key]['postcodeArea'] = $pa;
            $data[$key]['distance']     = self::calculateDistance($homeLat, $homeLng, $lat, $lng);
            
            foreach ($value as $pa => $vet) {
                $data[$key][$pa]['distance'] = self::calculateDistance($homeLat, $homeLng, $vet['lat'], $vet['lng']);
            }
            
            //usort($data[$key], "CheckavetHelper::usortDistance");
        }
        
        usort($data, "CheckavetHelper::usortDistance");
        
        return $data;
    }
    
    public static function usortDistance($a, $b)
    {
        if ($a['distance'] == $b['distance']) {
            return 0;
        }
        
        return $a['distance'] > $b['distance'] ? 1 : -1;
    }
    
    public static function calculateDistance($l1, $o1, $l2, $o2)
    {
        $l1 = deg2rad($l1);
        
        $sinl1 = sin($l1);
        
        $l2 = deg2rad($l2);
        
        $o1 = deg2rad($o1);
        
        $o2 = deg2rad($o2);
        
        return (7926 - 26 * $sinl1) * asin(min(1, 0.707106781186548 * sqrt((1 - (sin($l2) * $sinl1) - cos($l1) * cos($l2) * cos($o2 - $o1)))));
    }
    
    public static function validateUKPostcode($postcode)
    {
        if (preg_match(self::VALID_POSTCODE_REGEXP, strtoupper($postcode)))
            return true;
        
        return false;
    }
    
    public static function geocodePostCode($postcode)
    {
        // Initialize delay in geocode speed
        $delay    = 0;

        $base_url = "http://maps.google.com/maps/geo?output=xml&sensor=false";
                
        $geocode_pending = true;
        
        $request_url = "http://maps.google.com/maps/geo?output=xml&sensor=false" . "&q=" . urlencode($postcode);
        		
        while ($geocode_pending) {
            
            $xml = simplexml_load_file($request_url) or die("url not loading");

            $status = $xml->Response->Status->code;
            
            if (strcmp($status, "OK") == 0 || strcmp($status, "200") == 0) {
                // Successful geocode
                $geocode_pending = false;
                
                $coords = $xml->Response->Placemark->Point->coordinates;
                $coords = explode(",", $coords);
                
                $geocode = array(
                    $coords[1],
                    $coords[0]
                );
                
            } else if (strcmp($status, "OVER_QUERY_LIMIT") == 0 || strcmp($status, "620") == 0) {
                // $geocode_pending = false;
                $delay += 10000;
            } else {
                // failure to geocode
                $geocode_pending = false;
                $geocode = false;
            }
            usleep($delay);
        }
        
        return $geocode;
    }

	public static function createRater($id, $table, $max)
	{		
		$db = JFactory::getDbo();
		
		$query = $db->getQuery(true);
		$query->select('obj_id, rating');
		$query->from('#__checkavet_ratings');
		$query->where('obj_table = '.$db->quote($table).' AND state = 1');
		$db->setQuery($query);
			
		$results = $db->loadObjectList();
		
		$total = 0;	
		$rating_count = count($results);
		
		if($rating_count > 0)
		{			
			foreach($results as $result)
				$total += $result->rating;
			
			$rating_avg = round($total / $rating_count);
			$rating = $rating_avg * $max;
		}
		else
		{
			$rating_avg = 0;
			$rating = 0;
		}
		
		$img = '';

		// look for images in template if available
		$starImageOn = JHtml::_('image', 'checkavet/images/rating_star.png', NULL, NULL, true);
		$starImageOff = JHtml::_('image', 'checkavet/images/rating_star_blank.png', NULL, NULL, true);

		for ($i=0; $i < $rating; $i++) {
			$img .= $starImageOn;
		}
		for ($i=$rating; $i < $max; $i++) {
			$img .= $starImageOff;
		}
		//$html .= '<span class="content_rating">';
		//$html .= JText::sprintf( 'PLG_VOTE_USER_RATING', $img, $rating_count );
		//$html .= "</span>\n<br />\n";
		
		$uri = JFactory::getURI();
		
		$html = '';
		$html .= '<form method="post" action="' . $uri->toString() . '">';
		$html .= '<div class="checkavet_rating">';
		$html .= '<div class="checkavet_rating_stars">';
		$html .= $img;
		$html .= '</div>';
		
		for($i = 1; $i <= $max; $i++)
		{
			$html .= '<input type="radio" name="user_rating" value="'.$i.'" />';
		}
		
		$html .= '&#160;<input class="button" type="submit" name="submit_vote" value="'. JText::_( 'PLG_VOTE_RATE' ) .'" />';
		$html .= '<input type="hidden" name="task" value="'.$table.'.vote" />';
		$html .= '<input type="hidden" name="url" value="'.  $uri->toString() .'" />';
		$html .= JHtml::_('form.token');
		$html .= '</div>';
		$html .= '</form>';
		
		return $html;
	}
    
    /**
     * Configure the Linkbar.
     *
     * @param   string  $vName  The name of the active view.
     *
     * @return  void
     * @since   1.6
     */
    public static function addSubmenu($vName)
    {
        JSubMenuHelper::addEntry(JText::_('COM_CHECKAVET_VETS_TITLE'), 'index.php?option=com_checkavet&view=vets', $vName == 'vets');
        JSubMenuHelper::addEntry(JText::_('COM_CHECKAVET_PETSERVICES_TITLE'), 'index.php?option=com_checkavet&view=petservices', $vName == 'pet services');
        JSubMenuHelper::addEntry(JText::_('COM_CHECKAVET_RATINGS_TITLE'), 'index.php?option=com_checkavet&view=ratings', $vName == 'ratings');
    }
}

