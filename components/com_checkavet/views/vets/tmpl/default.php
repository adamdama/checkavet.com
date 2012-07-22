<?php
/**
 * @version		$Id: default.php 21576 2011-06-19 16:14:23Z chdemko $
 * @package		Joomla.Administrator
 * @subpackage	com_checkavet
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

require_once(JPATH_COMPONENT.'/helpers/html.php');

JFactory::getDocument()->addStyleSheet('templates/checkavet/shadowbox/shadowbox.css')
						->addScript('templates/checkavet/shadowbox/shadowbox.js');

?>
<div id="content">
	<div id="results">
        <div class="header">
        	<h1>
            	<?php
                	echo "Showing vets closest to: ".$this->postcode;
				?>                
            </h1>
            <h2>
            	<?php
					echo (count($this->vets)+count($this->featured))." results";
				?>
            </h2>
            <hr />
        </div>
    	<div class="scroller">  
    		<?php
				$tryAgain = true;
				if($this->featured){
					foreach($this->featured as $vet)
					{
					    $this->vet = $vet;
                        echo $this->loadTemplate('vet');
					}
					
					$tryAgain = false;
				}
			?>      
        	<?php
				if($this->vets){
					foreach($this->vets as $vet)
					{
					    $this->vet = $vet;
                        echo $this->loadTemplate('vet');
					}
					
					$tryAgain = false;
				}
				
				if($tryAgain)
				{
					?>
					<p>Sorry you result has returned no results. Please <a href="<?php echo JURI::base(); ?>">click here</a> and try again.</p>
					<?php
				}
			?>
    	</div>
    </div>
</div>
<form name="request" action="<?php echo JRoute::_('vets'); ?>">
	<input type="hidden" name="postcode" value="<?php echo JRequest::getVar('postcode', ''); ?>" />
    <input type="hidden" name="emergency" value="<?php echo JRequest::getVar('emergency', ''); ?>" />
    <input type="hidden" name="view" value="vets" />
    <input type="hidden" name="option" value="com_checkavet" />
</form>
