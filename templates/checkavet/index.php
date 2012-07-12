<?php
/**
 * @version                $Id: index.php 21518 2011-06-10 21:38:12Z chdemko $
 * @package                Joomla.Site
 * @subpackage	Templates.beez_20
 * @copyright        Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license                GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

JHtml::_('behavior.framework', true);

// get params
//$color              = $this->params->get('templatecolor');
$app                = JFactory::getApplication();
$doc				= JFactory::getDocument();
$templateparams     = $app->getTemplate(true)->params;
$view				= JRequest::getString('view');

$facebookLink = '<div class="icon-link"><a href="'.$templateparams->get('facebookLink').'" target="_blank"><img src="templates/checkavet/images/facebook.png" alt="facebook" /></a></div>';
$twitterLink = '<div class="icon-link"><a href="'.$templateparams->get('twitterLink').'" target="_blank"><img src="templates/checkavet/images/twitter.png" alt="facebook" /></a></div>';
$copyright = '<span class="copyright">'.$templateparams->get('copyright').'</span>';
$contactLink = '<a class="contact-link" href="mailto: '.$templateparams->get('contactEmail').'">'.$templateparams->get('contactWord').'</a>';


if($view == "home")
{
	$doc->addScript($this->baseurl.'/templates/checkavet/js/jquery.validate.min.js', 'text/javascript', true);
	$doc->addScript($this->baseurl.'/templates/checkavet/js/additional-methods.min.js', 'text/javascript', true);
	$doc->addScript($this->baseurl.'/templates/checkavet/js/home.js', 'text/javascript', true);
	
}
else
{	
	$doc->addScript($this->baseurl.'/templates/checkavet/js/results.js', 'text/javascript', true);	
}
//if(file_exists($this->baseurl.'/templates/checkavet/js/'.$view.'.js')) 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>">
    <head>
            <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
            <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/checkavet/css/main.css" type="text/css" />
            <?php if(JRequest::getString('view') == "home") { ?>
            	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/checkavet/css/modules.css" type="text/css" />
            <?php } ?>
            
			<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/checkavet/js/jquery-1.7.1.min.js"></script>
            <jdoc:include type="head" />
            <!--[if lte IE 6]>
                <link href="<?php echo $this->baseurl ?>/templates/checkavet/css/ieonly.css" rel="stylesheet" type="text/css" />
            <![endif]-->
            <!--[if IE 7]>
                <link href="<?php echo $this->baseurl ?>/templates/checkavet/css/ie7only.css" rel="stylesheet" type="text/css" />
            <![endif]-->
            <script type="text/javascript">				
				var _gaq = _gaq || [];				
				_gaq.push(['_setAccount', 'UA-27723761-1']);				
				_gaq.push(['_trackPageview']);				
				(function() {				
					var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;				
					ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';				
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);				
				})();
			</script>


    </head>
    <body>
    
    	<div id="site-wrapper">
			<?php if ($view != "home") { 	?>			
                <div class="left-bg">
                    <img src="<?php echo $this->baseurl;?>/images/checkavet/dog-left.jpg" alt="checkavet" />
                </div>
                <div class="right-bg">
                    <img src="<?php echo $this->baseurl;?>/images/checkavet/cat-right.jpg" alt="checkavet" />
                </div>
            <?php } ?>
            <div id="header" onclick="window.location.href = ('<?php echo $this->baseurl ?>')">
            </div>
            
            <jdoc:include type="modules" name="menu" />
            <jdoc:include type="message" />
            <jdoc:include type="component" />
            
            <?php if($view == "home") { ?>
                <div id="content">
                    <div id="search-row">
                        <jdoc:include type="modules" name="vetsearch" />
                        <jdoc:include type="modules" name="servicessearch" />  
                    </div>
                    
                    <div id="feedback-row">
                        <jdoc:include type="modules" name="leavefeedback" />
                    </div>
                </div>
            <?php } ?>
            
            <div id="footer">
            	<div class="left">
               		<?php echo $facebookLink.$twitterLink; ?>
                </div>
            	<div class="right">
            		<?php echo $copyright.$contactLink; ?>                
                </div>
            </div>            
    	</div>
        
        
    </body>
</html>
