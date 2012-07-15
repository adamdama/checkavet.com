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
				<table class="adminformlist"> 
					<tr>
						<td>
							<?php echo $this->form->getLabel('name'); ?>
						</td>
						<td>
							<?php echo $this->form->getInput('name'); ?>
						</td>
					</tr> 
					<tr>
						<td>
							<?php echo $this->form->getLabel('email'); ?>
						</td>
						<td>
							<?php echo $this->form->getInput('email'); ?>
						</td>
					</tr>  <?php echo $this->form->getLabel('rating'); ?>
					<?php echo $this->state->get('rating'); ?>
				</table>
				<div class="clr"></div>
				<?php echo $this->form->getInput('ratingtext'); ?>
			</fieldset>
		</div>
		<div>
			<input type="button" value="<?php echo JText::_('COM_CHECKAVET_BUTTON_SUBMIT_RATING'); ?>" onclick="Joomla.submitbutton('submit')" />
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="return" value="<?php echo JRequest::getCmd('return');?>" />
			<?php echo JHtml::_('form.token'); ?>
		</div>
	</form>