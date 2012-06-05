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
<div id="servicessearch-module" class="rounded-corners">
    <form id="servicessearch-module-form" action="<?php echo JRoute::_('index.php');?>" method="post" novalidate="novalidate">
    	<div>
            <div class="logo">
                <img src="images/checkavet/otherpetservices.png" />
            </div>
            <div class="search-container">
                <div class="search-label label">
                    <label for="mod-servicessearch-servicetype"><?php echo $listLabel; ?></label>
                </div>
                <div class="list-box">
                	<select id="mod-servicessearch-servicetype" class="list-input required" name="servicetype">
                    	<option value="">EG: Groomers</option>
                    	<?php foreach($servicetypes as $type)
						{
							echo '<option value="'.$type.'">'.$type.'</option>';
						} ?>
                    </select>
                </div>   
            </div> 
            <div class="search-container">
                <div class="search-label label">
                    <label for="mod-servicessearch-postcode"><?php echo $searchLabel; ?></label>
                </div>
                <div class="search-box">
                    <input type="text" id="mod-servicessearch-postcode" class="search-input required UKPostcode"   name="postcode" maxlength="8" onfocus="if(this.value=='EG: BN3 3DD') this.value='';" onblur="if(this.value=='') this.value='EG: BN3 3DD';" value="EG: BN3 3DD" />
                    <div class="search-submit"><input type="submit" value="GO" class="search-submit" id="mod-servicessearch-submit" /></div>
                </div>   
            </div>   
        </div> 
        <input type="hidden" name="task" value="petservices" />
        <input type="hidden" name="option" value="com_checkavet" />
    </form>
</div>