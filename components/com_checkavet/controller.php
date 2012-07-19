<?php
/**
 * @version		$Id: controller.php 22338 2011-11-04 17:24:53Z github_bot $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Checkavet master display controller. sets up variables and sends to correct place.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_checkavet
 * @since		1.6
 */
class CheckavetController extends JController
{
	/**
	 * @var		string	The default view.
	 * @since	1.6
	 */
	protected $default_view = 'home';

	/**
	 * Method to display a view.
	 *
	 * @param	boolean			If true, the view output will be cached
	 * @param	array			An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{

		$user = JFactory::getUser();

		if ($user->get('id')) {
			$cachable = false;
		}
		
		$vName	= JRequest::getCmd('view', 'home');
		JRequest::setVar('view', $vName);

		return parent::display($cachable, $urlparams);
	}

	/**
	 * Method to save a rating.
	 *
	 * @return	void
	 * @since	1.6.1
	 */
	function rate($cachable = false, $urlparams = false)
	{
		$rating = JRequest::getVar('user_rating' , 0);
		$id = JRequest::getVar('item_id' , 0);
		$table = JRequest::getVar('table' , '');
		$form = JRequest::getVar('jform', '');
		$email = $form['email'];
		$name = $form['name'];
		$rating_text = $form['ratingtext'];
		
		if($email != '' && $rating > 0)
		{			
			$model = $this->getModel('Rate');
			$model->setState('email', $email);
			
			$exists = $model->getItem();
			
			if($exists->id == '')
			{				
				if (!$model->storeVote($id, $rating, $email, $name, $rating_text))
				{
					$this->message = JText::_('COM_COHECKAVET_VOTE_FAILURE');
					//JError::raiseError(10255, 'COM_COHECKAVET_VOTE_FAILURE');
				//die('1');
					//$this->setRedirect($viewName, JText::_('COM_CONTENT_ARTICLE_VOTE_FAILURE'));
					//$this->setRedirect($viewName, JText::_('COM_CONTENT_ARTICLE_VOTE_SUCCESS'));
				}
			}
			else
			{
				$this->message = JText::_('COM_COHECKAVET_VOTE_MULTIPLE_FAILURE');
				die('2');
			}
		}
		else
		{
			$this->message = JText::_('COM_COHECKAVET_VOTE_FAILURE');
				die('3');
		}
		
		$this->display($cachable, $urlparams);
	}
}
