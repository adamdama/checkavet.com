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

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');


?>
<div id="content">
	<div id="results">
        <div class="header">
        	<h1>
            	<?php
                	echo "Showing ".$this->petservice." closest to: ".$this->postcode;
				?>                
            </h1>
            <h2>
            	<?php
					echo count($this->petservices)." results";
				?>
            </h2>
            <hr />
        </div>
    	<div class="scroller">        
        	<?php
				if($this->featured){
					foreach($this->featured as $petservice)
					{
					    $this->petservice = $petservice;
                        echo $this->loadTemplate('petservice');
					}
				}
			?>      
        	<?php
				if($this->petservices){
					foreach($this->petservices as $petservice)
					{
					    $this->petservice = $petservice;
                        echo $this->loadTemplate('petservice');
					}
				}
			?>
    	</div>
    </div>
</div>