<?php
/**
 * @version		$Id: article.php 21766 2011-07-08 12:20:23Z eddieajau $
 * @package		Joomla.Administrator
 * @subpackage	com_checkavet
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * @package		Joomla.Administrator
 * @subpackage	com_checkavet
 * @since		1.6
 */
class CheckavetControllerVet extends JControllerForm
{
	/**
	 * Class constructor.
	 *
	 * @param	array	$config	A named array of configuration variables.
	 *
	 * @return	JControllerForm
	 * @since	1.6
	 */
	function __construct($config = array())
	{
		// An article edit form can come from the vets or featured view.
		// Adjust the redirect view on the value of 'return' in the request.
		//if (JRequest::getCmd('return') == 'featured') {
		//	$this->view_list = 'featured';
		//	$this->view_item = 'vet&return=featured';
		//}

		parent::__construct($config);
	}

	/**
	 * Method to run batch operations.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public function batch($model)
	{
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Set the model
		$model	= $this->getModel('Vet', '', array());

		// Preset the redirect
		$this->setRedirect(JRoute::_('index.php?option=com_checkavet&view=vets'.$this->getRedirectToListAppend(), false));

		return parent::batch($model);
	}
}
