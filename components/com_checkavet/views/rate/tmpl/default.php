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

JFactory::getDocument()->addStyleSheet('templates/checkavet/shadowbox/shadowbox.css')
						->addStyleSheet('templates/checkavet/css/modal.css')
						->addScript('templates/checkavet/shadowbox/shadowbox.js');
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task) {
		if (task == 'article.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
			<?php echo $this->form->getField('ratingtext')->save(); ?>
			Joomla.submitform(task);
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>
<div class="edit item-page">
	<form action="<?php echo JRoute::_('index.php?option=com_checkavet&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">
		<div>
			<fieldset class="adminform">
				<div class="field-row">					
					<?php echo $this->state->get('rating'); ?>
				</div>
				<div class="field-row">
					<?php echo $this->form->getLabel('name'); ?>
					<?php echo $this->form->getInput('name'); ?>
				</div> 
				<div class="field-row">
					<?php echo $this->form->getLabel('email'); ?>
					<?php echo $this->form->getInput('email'); ?>
				</div>
				<div class="clr"></div>
				<div class="field-row-editor">
					<?php echo $this->form->getInput('ratingtext'); ?>
				</div>
				<div class="field-row">
					<input type="button" value="<?php echo JText::_('COM_CHECKAVET_BUTTON_SUBMIT_RATING'); ?>" onclick="Joomla.submitbutton('submit')" />
					<input type="hidden" name="task" value="validate" />
					<input type="hidden" name="view" value="rate" />
					<input type="hidden" name="item_id" value="<?php echo JRequest::getVar('item_id', 0); ?>" />
					<input type="hidden" name="table" value="<?php echo JRequest::getVar('table', ''); ?>" />
					<?php echo JHtml::_('form.token'); ?>
				</div>			
			</fieldset>
		</div>
	</form>
</div>