<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
/**
 * Content Component Category Tree
 *
 * @static
 * @package		Joomla.Site
 * @subpackage	com_content
 * @since 1.6
 */
class CheckavetHelperHtml
{
	public static function clean_blanks($input)
	{
		foreach($input as $key => $value)
        {
            if($value == '' || $value == null)
            {
                $input[$key] = '&nbsp;';
            }
        }
        
        return $input;
	}
}
