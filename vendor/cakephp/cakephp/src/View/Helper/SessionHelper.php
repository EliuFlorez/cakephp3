<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         1.1.7
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\View\Helper;

use Cake\Network\Session;
use Cake\View\Helper;
use Cake\View\Helper\StringTemplateTrait;
use Cake\View\View;

/**
 * Session Helper.
 *
 * Session reading from the view.
 *
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/session.html
 */
class SessionHelper extends Helper {

	use StringTemplateTrait;

/**
 * Default templates to use.
 *
 * @var array
 */
	protected $_defaultTemplates = [
		'flash' => '<div id="{{key}}-message" class="{{class}}">{{message}}</div>'
	];

/**
 * Construct the helper and sets up templates
 *
 * @param \Cake\View\View $view The View this helper is being attached to.
 * @param array $settings Configuration settings for the helper.
 */
	public function __construct(View $view, $settings = []) {
		$settings += ['templates' => null];
		parent::__construct($view, $settings);

		$this->initStringTemplates($this->_defaultTemplates);
	}

/**
 * Used to read a session values set in a controller for a key or return values for all keys.
 *
 * In your view: `$this->Session->read('Controller.sessKey');`
 * Calling the method without a param will return all session vars
 *
 * @param string $name the name of the session key you want to read
 * @return mixed values from the session vars
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/session.html#SessionHelper::read
 */
	public function read($name = null) {
		return Session::read($name);
	}

/**
 * Used to check is a session key has been set
 *
 * In your view: `$this->Session->check('Controller.sessKey');`
 *
 * @param string $name
 * @return boolean
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/session.html#SessionHelper::check
 */
	public function check($name) {
		return Session::check($name);
	}

/**
 * Returns last error encountered in a session
 *
 * In your view: `$this->Session->error();`
 *
 * @return string last error
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/session.html#displaying-notifications-or-flash-messages
 */
	public function error() {
		return Session::error();
	}

/**
 * Used to render the message set in Controller::Session::setFlash()
 *
 * In your view: $this->Session->flash('somekey');
 * Will default to flash if no param is passed
 *
 * You can pass additional information into the flash message generation. This allows you
 * to consolidate all the parameters for a given type of flash message into the view.
 *
 * {{{
 * echo $this->Session->flash('flash', array('params' => array('class' => 'new-flash')));
 * }}}
 *
 * The above would generate a flash message with a custom class name. Using $attrs['params'] you
 * can pass additional data into the element rendering that will be made available as local variables
 * when the element is rendered:
 *
 * {{{
 * echo $this->Session->flash('flash', array('params' => array('name' => $user['User']['name'])));
 * }}}
 *
 * This would pass the current user's name into the flash message, so you could create personalized
 * messages without the controller needing access to that data.
 *
 * Lastly you can choose the element that is rendered when creating the flash message. Using
 * custom elements allows you to fully customize how flash messages are generated.
 *
 * {{{
 * echo $this->Session->flash('flash', array('element' => 'my_custom_element'));
 * }}}
 *
 * If you want to use an element from a plugin for rendering your flash message you can do that using the
 * plugin param:
 *
 * {{{
 * echo $this->Session->flash('flash', array(
 *   'element' => 'my_custom_element',
 *   'params' => array('plugin' => 'my_plugin')
 * ));
 * }}}
 *
 * @param string $key The [Message.]key you are rendering in the view.
 * @param array $attrs Additional attributes to use for the creation of this flash message.
 *    Supports the 'params', and 'element' keys that are used in the helper.
 * @return string
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/session.html#SessionHelper::flash
 */
	public function flash($key = 'flash', $attrs = []) {
		if (!Session::check('Message.' . $key)) {
			return '';
		}

		$flash = Session::read('Message.' . $key);
		$message = $flash['message'];
		unset($flash['message']);

		if (!empty($attrs)) {
			$flash = array_merge($flash, $attrs);
		}

		if ($flash['element'] === 'default') {
			$class = 'message';
			if (!empty($flash['params']['class'])) {
				$class = $flash['params']['class'];
			}
			$out = $this->formatTemplate('flash', [
				'class' => $class,
				'key' => $key,
				'message' => $message
			]);
		} elseif (!$flash['element']) {
			$out = $message;
		} else {
			$options = array();
			if (isset($flash['params']['plugin'])) {
				$options['plugin'] = $flash['params']['plugin'];
			}
			$tmpVars = $flash['params'];
			$tmpVars['message'] = $message;
			$out = $this->_View->element($flash['element'], $tmpVars, $options);
		}
		Session::delete('Message.' . $key);
		return $out;
	}

/**
 * Used to check is a session is valid in a view
 *
 * @return boolean
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/session.html#SessionHelper::valid
 */
	public function valid() {
		return Session::valid();
	}

/**
 * Event listeners.
 *
 * @return array
 */
	public function implementedEvents() {
		return [];
	}

}
