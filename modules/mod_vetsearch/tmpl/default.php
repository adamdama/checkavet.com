<?php
/**
 * @version		$Id: default.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Site
 * @subpackage	mod_search
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<div id="vetsearch-module" class="rounded-corners">
    <form id="vetsearch-module-form" action="vets" method="post" novalidate="novalidate">
    	<div>
            <div class="logo">
                <img src="images/checkavet/findavet.png" />
            </div>
            <div class="search-container">
                <div class="search-label label">
                    <label for="mod-vetsearch-postcode"><?php echo $label; ?></label>
                </div>
                <div class="search-box">
                    <input type="text" id="mod-vetsearch-postcode" class="search-input required UKPostcode"   name="postcode" maxlength="8" onfocus="if(this.value=='EG: BN3 3DD') this.value='';" onblur="if(this.value=='') this.value='EG: BN3 3DD';" value="EG: BN3 3DD" />
                    <div class="search-submit"><input type="submit" value="GO" class="search-submit" id="mod-vetsearch-submit" /></div>
                </div> 
                <input type="checkbox" id="mod-vetsearch-24hour" class="checkbox" name="emergency" />
                <span class="label"><label for="mod-vetsearch-24hour">24 hour vets only</label></span>   
            </div>   
        </div> 
        <input type="hidden" name="view" value="vets" />
        <input type="hidden" name="option" value="com_checkavet" />
    </form>
    <p class="bold"><?php echo $para1; ?></p>
    <p><?php echo $para2; ?></p>
</div>