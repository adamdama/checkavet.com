<?php
/**
 * @version		$Id: search.php 22359 2011-11-07 16:31:03Z github_bot $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Search component helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_search
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
	 * @return	JObject
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;
		$assetName = 'com_search';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}
	
	public static function groupResultsByPostcode($results)
	{
		if($results == null) return;
		
		$grouped = array();
		
		foreach($results as $result)
		{	
			if(!self::validateUKPostcode($result['postcode']))
				continue;
			
			$postcodeArea = CheckavetHelper::getPostcodeArea($result['postcode']);
			if(!$postcodeArea)
				continue;
			
			if(!isset($grouped[$postcodeArea]))
				$grouped[$postcodeArea] = array();
				
			array_push($grouped[$postcodeArea], $result);			
		}
		
		return $grouped;
	}
	
	public static function getPostcodeArea($postcode)
	{
		preg_match(self::POSTCODE_AREA_REGEXP, strtoupper($postcode),$match);
		if(count($match) == 0)
			return false;
		
		$postcodeArea = $match[0];
		
		return $postcodeArea;
	}
	
	
	
	public static function sortByDistance($postcode, $data)
	{
		require_once(JPATH_COMPONENT.DS.'models'.DS.'postcodes.php');
		$model = new CheckavetModelPostcodes();
		$postcodes = $model->getPostcodes();
		
		$postcodeArea = self::getPostcodeArea($postcode);		
		$homeLat = $postcodes[$postcodeArea]['lat'];
		$homeLng = $postcodes[$postcodeArea]['lng'];
		
		foreach($data as $key => $value)
		{
			$pa = self::getPostcodeArea($key);
			$lat = $postcodes[$pa]['lat'];
			$long = $postcodes[$pa]['lng'];
			
			$data[$key]['postcodeArea'] = $pa;
			$data[$key]['distance'] = self::calculateDistance($homeLat, $homeLng, $lat, $long); 
						
			foreach($value as $pa => $vet)
			{
				$data[$key][$pa]['distance'] = self::calculateDistance($homeLat, $homeLng, $vet['lat'], $vet['lng']);
			}
			
			//usort($data[$key], "CheckavetHelper::usortDistance");
		}
		
		usort($data, "CheckavetHelper::usortDistance");
				
		return $data;
	}
	
	public static function usortDistance($a, $b)
	{
		if($a['distance'] == $b['distance'])
		{
			return 0;
		}
		
		return $a['distance'] > $b['distance'] ? 1 : -1;
	}
	
	public static function calculateDistance($l1, $o1, $l2, $o2)
	{		
		$l1 = deg2rad ($l1);

		$sinl1 = sin ($l1);
	
		$l2 = deg2rad ($l2);
	
		$o1 = deg2rad ($o1);
	
		$o2 = deg2rad ($o2);
	
		return (7926 - 26 * $sinl1) * asin (min (1, 0.707106781186548 * sqrt ((1 - (sin ($l2) * $sinl1) - cos ($l1) * cos ($l2) * cos ($o2 - $o1)))));
	}
	
	public static function validateUKPostcode($postcode)
	{	 
		if (preg_match(self::VALID_POSTCODE_REGEXP, strtoupper($postcode)))			
			return true;		
		
		return false;
	}
	
	public static function geocodePostCode($postcode)
	{
		$username="checkavet";
		$password="password";
		$database="checkavet";
		
		define("MAPS_HOST", "maps.google.com");
		define("KEY", "AIzaSyBK2oBWwjz7a9TJQwjpZcFlSNxm_Cvq-P8");
		
		// Opens a connection to a MySQL server
		$connection = mysql_connect("localhost", $username, $password);
		if (!$connection) {
		  die("Not connected : " . mysql_error());
		}
		
		// Set the active MySQL database
		$db_selected = mysql_select_db($database, $connection);
		if (!$db_selected) {
		  die("Can\'t use db : " . mysql_error());
		}
		
		// Select all the rows in the markers table
		$query = "SELECT * FROM jmla_vets WHERE 1";
		$result = mysql_query($query);
		if (!$result) {
		  die("Invalid query: " . mysql_error());
		}
		
		// Initialize delay in geocode speed
		$delay = 0;
		//$base_url = "http://maps.googleapis.com/maps/api/geocode/xml?sensor=false";
		$base_url = "http://maps.google.com/maps/geo?output=xml&sensor=false";
		
		$success = 0;
		$fail = 0;
		$total = 0;
		
		// Iterate through the rows, geocoding each address
		while ($row = @mysql_fetch_assoc($result)) {
		  $geocode_pending = true;
		  
		  if($row['lat'] != 0 && $row['lng'] != 0)
		  	continue;
		  
		  $total++;
		  if($total <= 2)
		  {
			  //continue;
		  }
		  
		  while ($geocode_pending) {
			$address = "";
		    $address .= $row["address1"] == "" ? "" : $row['address1'].", ";
		    $address .= $row["address2"] == "" ? "" : $row['address2'].", ";
		    $address .= $row["address3"] == "" ? "" : $row['address3'].", ";
		    $address .= $row["county"] == "" ? "" : $row['county'].", ";
		    $address .= $row["postcode"] == "" ? "" : $row['postcode'];
			//$address = substr($address, 0, -2);
			
		    $id = $row["id"];
		    //$request_url = $base_url . "&address=" . urlencode($address);
			$request_url = $base_url . "&q=" . urlencode($address);
			
		    $xml = simplexml_load_file($request_url) or die("url not loading");	
		    //$status = $xml->status;
			$status = $xml->Response->Status->code;
			
		    if (strcmp($status, "OK") == 0 || strcmp($status, "200") == 0) {
		      // Successful geocode
		      $geocode_pending = false;
		
			 $coords = $xml->Response->Placemark->Point->coordinates; 
			 $coords = explode(",",$coords);
			 $lat = $coords[0];
			 $lng = $coords[1];
		
		      $query = sprintf("UPDATE jmla_vets " .
		             " SET lat = '%s', lng = '%s' " .
		             " WHERE id = '%s' LIMIT 1;",
		             mysql_real_escape_string($lat),
		             mysql_real_escape_string($lng),
		             mysql_real_escape_string($id));
				echo $query.'<br />';
		      $update_result = mysql_query($query);
		      if (!$update_result) {
				 $fail++; 
		        die("Invalid query: " . mysql_error());
		      } else {
				  $success++;
			  }
			  
		    } else if (strcmp($status, "OVER_QUERY_LIMIT") == 0 || strcmp($status, "620") == 0) {
		      // sent geocodes too fast
			  echo "oql retrying {$row['id']}<br />";
		     // $geocode_pending = false;
				 $fail++; 
		      $delay += 10000;
		    } else {
		      // failure to geocode
			  $fail++; 
		      $geocode_pending = false;
		      echo "Address " . $address . " failed to geocoded. ";
		      echo "Received status " . $status . "
		\n";
		    }
		    usleep($delay);
		  }
		 
		  if($total == 50)
		  {
			  break;
		  }
		}
	}

	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	$vName	The name of the active view.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public static function addSubmenu($vName)
	{
		JSubMenuHelper::addEntry(
			JText::_('JGLOBAL_ARTICLES'),
			'index.php?option=com_content&view=articles',
			$vName == 'articles'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_CONTENT_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&extension=com_content',
			$vName == 'categories');
		JSubMenuHelper::addEntry(
			JText::_('COM_CONTENT_SUBMENU_FEATURED'),
			'index.php?option=com_content&view=featured',
			$vName == 'featured'
		);
	}
}

