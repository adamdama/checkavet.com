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

// reorder vets so that fewatured come up first

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
					echo count($this->vets)." results";
				?>
            </h2>
            <hr />
        </div>
    	<div class="scroller">        
        	<?php
				if($this->vets){
					foreach($this->vets as $vet)
					{
					    $this->vet = $vet;
                        echo $this->loadTemplate('vet');
					}
				}
			?>
    	</div>
    </div>
</div>