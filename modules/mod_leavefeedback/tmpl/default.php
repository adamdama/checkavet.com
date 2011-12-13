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
<div id="leavefeedback-module">
	<h1 class="blue bold">Coming soon...</h1>
    <p class="blue bold">
    	<span class="row">The opportunity to leave feedback about your Veterinary experience and rate them based on 5 different criteria.</span>
    	<span class="row">Be honest when leaving feedback as this allows other Pet owners to get the best from this site.</span>
    </p>
    <?php if(JRequest::getString('feedbackEmail') == ""){ ?>
    <p>
    	<span class="row blue bold">Want to be the first to review your vet?</span>
    	<span class="row">Enter your email and we will contact you as soon as the rating system goes live!</span>
    </p>

    <form id="leavefeedback-module-form" action="<?php echo JRoute::_('index.php');?>" method="post" novalidate="novalidate">
        <div class="email-box">
            <input type="text" id="mod-leavefeedback-email" class="email-input required email"   name="feedbackEmail" onfocus="if(this.value=='EG: example@example.com') this.value='';" onblur="if(this.value=='') this.value='EG: example@example.com';" value="EG: example@example.com" />
            <div class="email-submit"><input type="submit" value="OK" class="email-submit" id="mod-leavefeedback-submit" /></div>
        </div>
        <input type="hidden" name="task" value="home" />
        <input type="hidden" name="option" value="com_checkavet" />
    </form>
    
    <?php } else { ?>
    <p>
    	<span class="blue bold">Thank you!</span>
    </p>
    <?php } ?>
</div>