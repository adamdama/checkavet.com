<?php
/**
 * @version		$Id: default.php 21576 2011-06-19 16:14:23Z chdemko $
 * @package		Joomla.Administrator
 * @subpackage	com_checkavet
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.calendar');
JHtml::_('behavior.formvalidation');

// Create shortcut to parameters.
$lang = JFactory::getLanguage();
$lang->load('com_checkavet', JPATH_ADMINISTRATOR);

$params = $this->state->get('params');

JFactory::getDocument()->addStyleSheet('templates/checkavet/css/modal.css');
?>
<div class="success">
	<script type="text/javascript">
		jQuery(document).ready(function()
		{
			window.parent.Shadowbox.skin.dynamicResize(jQuery('#site-wrapper').width(), jQuery('#site-wrapper').height());
			window.parent.Shadowbox.successful = true;
		});
	</script>
	<?php echo JText::_('COM_CHECKAVET_VOTE_SUCCESS'); ?>
	<a onclick="window.parent.Shadowbox.close();"><?php echo JText::_('COM_CHECKAVET_CLICK_TO_CLOSE_WINDOW'); ?></a>
</div>