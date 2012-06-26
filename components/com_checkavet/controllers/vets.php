<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * @package		Joomla.Site
 * @subpackage	com_content
 */
class CheckavetControllerVets extends JControllerForm
{
	/**
	 * Method to get a model object, loading it if required.
	 *
	 * @param	string	$name	The model name. Optional.
	 * @param	string	$prefix	The class prefix. Optional.
	 * @param	array	$config	Configuration array for model. Optional.
	 *
	 * @return	object	The model.
	 *
	 * @since	1.5
	 */
	public function getModel($name = 'form', $prefix = '', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}

	/**
	 * Method to save a rating.
	 *
	 * @return	void
	 * @since	1.6.1
	 */
	function rate()
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		$user_rating = JRequest::getInt('user_rating', -1);

		if ( $user_rating > -1 ) {
			$url = JRequest::getString('url', '');
			$id = JRequest::getInt('id', 0);
			$viewName = JRequest::getString('view', $this->default_view);
			$model = $this->getModel($viewName);

			if ($model->storeVote($id, $user_rating)) {
				$this->setRedirect($url, JText::_('COM_CONTENT_ARTICLE_VOTE_SUCCESS'));
			} else {
				$this->setRedirect($url, JText::_('COM_CONTENT_ARTICLE_VOTE_FAILURE'));
			}
		}
	}
}
