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
//$images = json_decode($this->item->images);
//$urls = json_decode($this->item->urls);
?>
<div>
	<script type="text/javascript">
		jQuery(document).ready(function()
		{
			window.parent.Shadowbox.dynamicResize(jQuery(document.body).width(), jQuery(document.body).height());
		});
	</script>
	<a onclick="window.parent.Shadowbox.close();">Click here to close this window</a>
</div>