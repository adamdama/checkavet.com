<?php
/**
 * @version		$Id: edit.php 22370 2011-11-09 16:18:06Z github_bot $
 * @package		Joomla.Administrator
 * @subpackage	com_checkavet
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');

// Load the tooltip behavior.
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task) {
		if (task == 'article.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
			<?php //echo $this->form->getField('articletext')->save(); ?>
			Joomla.submitform(task, document.getElementById('item-form'));
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_checkavet&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo empty($this->item->id) ? JText::_('COM_CHECKAVET_NEW_PETSERVICE') : JText::sprintf('COM_CHECKAVET_EDIT_PETSERVICE', $this->item->id); ?></legend>
			<ul class="adminformlist">
				<li><?php echo $this->form->getLabel('id'); ?>
				<?php echo $this->form->getInput('id'); ?></li> 
                
				<li><?php echo $this->form->getLabel('name'); ?>
				<?php echo $this->form->getInput('name'); ?></li>

				<li><?php echo $this->form->getLabel('address1'); ?>
				<?php echo $this->form->getInput('address1'); ?></li>

				<li><?php echo $this->form->getLabel('address2'); ?>
				<?php echo $this->form->getInput('address2'); ?></li>

                <li><?php echo $this->form->getLabel('address3'); ?>
                <?php echo $this->form->getInput('address3'); ?></li>

                <li><?php echo $this->form->getLabel('postcode'); ?>
                <?php echo $this->form->getInput('postcode'); ?></li>

                <li><?php echo $this->form->getLabel('county'); ?>
                <?php echo $this->form->getInput('county'); ?></li>

                <li><?php echo $this->form->getLabel('town'); ?>
                <?php echo $this->form->getInput('town'); ?></li>

				<li><?php echo $this->form->getLabel('website'); ?>
				<?php echo $this->form->getInput('website'); ?></li>

				<li><?php echo $this->form->getLabel('email'); ?>
				<?php echo $this->form->getInput('email'); ?></li>

				<li><?php echo $this->form->getLabel('phone'); ?>
				<?php echo $this->form->getInput('phone'); ?></li>

				<li><?php echo $this->form->getLabel('fax'); ?>
				<?php echo $this->form->getInput('fax'); ?></li>

				<li><?php echo $this->form->getLabel('accredited'); ?>
				<?php echo $this->form->getInput('accredited'); ?></li>

				<li><?php echo $this->form->getLabel('24hour'); ?>
				<?php echo $this->form->getInput('24hour'); ?></li>

				<li><?php echo $this->form->getLabel('state'); ?>
				<?php echo $this->form->getInput('state'); ?></li>

				<li><?php echo $this->form->getLabel('access'); ?>
				<?php echo $this->form->getInput('access'); ?></li>

				<?php // if ($this->canDo->get('core.admin')): ?>
					<li><span class="faux-label"><?php echo JText::_('JGLOBAL_ACTION_PERMISSIONS_LABEL'); ?></span>
						<div class="button2-left"><div class="blank">
							<button type="button" onclick="document.location.href='#access-rules';">
								<?php echo JText::_('JGLOBAL_PERMISSIONS_ANCHOR'); ?>
							</button>
						</div></div>
					</li>
				<?php // endif; ?>

				<li><?php echo $this->form->getLabel('featured'); ?>
				<?php echo $this->form->getInput('featured'); ?></li> 

				<li><?php echo $this->form->getLabel('show_logo'); ?>
				<?php echo $this->form->getInput('show_logo'); ?></li> 

				<li><?php echo $this->form->getLabel('logo'); ?>
				<?php echo $this->form->getInput('logo'); ?></li>
			</ul>
                
			<div class="clr"></div>
			<img src="<?php echo $this->get('logo'); ?>" alt="<?php echo $this->get('logo'); ?>" />
			<div class="clr"></div>
			<?php echo $this->form->getLabel('petservicetext'); ?>
			<div class="clr"></div>
			<?php echo $this->form->getInput('petservicetext'); ?>
		</fieldset>
	</div>

	<div class="width-40 fltrt">
		<?php echo JHtml::_('sliders.start','content-sliders-'.$this->item->id, array('useCookie'=>1)); ?>

			<?php echo JHtml::_('sliders.panel',JText::_('COM_CHECKAVET_FIELDSET_PUBLISHING'), 'publishing-details'); ?>
			<fieldset class="panelform">
				<ul class="adminformlist">
					<li><?php echo $this->form->getLabel('created_by'); ?>
					<?php echo $this->form->getInput('created_by'); ?></li>

					<li><?php echo $this->form->getLabel('created_by_alias'); ?>
					<?php echo $this->form->getInput('created_by_alias'); ?></li>

					<li><?php echo $this->form->getLabel('created'); ?>
					<?php echo $this->form->getInput('created'); ?></li>

					<li><?php echo $this->form->getLabel('publish_up'); ?>
					<?php echo $this->form->getInput('publish_up'); ?></li>

					<li><?php echo $this->form->getLabel('publish_down'); ?>
					<?php echo $this->form->getInput('publish_down'); ?></li>

					<?php if ($this->item->modified_by) : ?>
						<li><?php echo $this->form->getLabel('modified_by'); ?>
						<?php echo $this->form->getInput('modified_by'); ?></li>

						<li><?php echo $this->form->getLabel('modified'); ?>
						<?php echo $this->form->getInput('modified'); ?></li>
					<?php endif; ?>

					<?php if ($this->item->version) : ?>
						<li><?php echo $this->form->getLabel('version'); ?>
						<?php echo $this->form->getInput('version'); ?></li>
					<?php endif; ?>

					<?php if ($this->item->hits) : ?>
						<li><?php echo $this->form->getLabel('hits'); ?>
						<?php echo $this->form->getInput('hits'); ?></li>
					<?php endif; ?>
				</ul>
			</fieldset>

			<?php $fieldSets = $this->form->getFieldsets('attribs'); ?>
			<?php foreach ($fieldSets as $name => $fieldSet) : ?>
				<?php echo JHtml::_('sliders.panel',JText::_($fieldSet->label), $name.'-options'); ?>
				<?php if (isset($fieldSet->description) && trim($fieldSet->description)) : ?>
					<p class="tip"><?php echo $this->escape(JText::_($fieldSet->description));?></p>
				<?php endif; ?>
				<fieldset class="panelform">
					<ul class="adminformlist">
					<?php foreach ($this->form->getFieldset($name) as $field) : ?>
						<li><?php echo $field->label; ?>
						<?php echo $field->input; ?></li>
					<?php endforeach; ?>
					</ul>
				</fieldset>
			<?php endforeach; ?>
            
			<?php echo JHtml::_('sliders.panel',JText::_('JGLOBAL_FIELDSET_METADATA_OPTIONS'), 'meta-options'); ?>
			<fieldset class="panelform">
				<?php echo $this->loadTemplate('metadata'); ?>
			</fieldset>

		<?php echo JHtml::_('sliders.end'); ?>
	</div>
    <?php /*
	<div class="clr"></div>
	<?php // if ($this->canDo->get('core.admin')): ?>
		<div class="width-100 fltlft">
			<?php echo JHtml::_('sliders.start','permissions-sliders-'.$this->item->id, array('useCookie'=>1)); ?>

				<?php echo JHtml::_('sliders.panel',JText::_('COM_CHECKAVET_FIELDSET_RULES'), 'access-rules'); ?>
				<fieldset class="panelform">
					<?php echo $this->form->getLabel('rules'); ?>
					<?php echo $this->form->getInput('rules'); ?>
				</fieldset>

			<?php echo JHtml::_('sliders.end'); ?>
		</div>
	<?php // endif; ?>
     */ ?>
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="return" value="<?php echo JRequest::getCmd('return');?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
