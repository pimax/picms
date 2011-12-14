<?php
/**
 * EAuthServiceBase class file.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://code.google.com/p/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once 'IAuthService.php';

/**
 * EAuthServiceBase is a base class for providers. 
 * @package application.extensions.eauth
 */
class EAuthServiceBase extends CComponent implements IAuthService {
	
	/**
	 * @var string the service name.
	 */
	protected $name;
	
	/**
	 *
	 * @var string the service title to display in views. 
	 */
	protected $title;
	
	/**
	 * @var string the service type (e.g. OpenID, OAuth).
	 */
	protected $type;
	
	/**
	 * @var array arguments for the jQuery.eauth() javascript function.
	 */
	protected $jsArguments = array();
	
	/**
	 * @var array authorization attributes.
	 * @see getAttribute
	 * @see getItem
	 */
	protected $attributes = array();
	
	/**
	 * @var boolean whether user was successfuly authenticated.
	 * @see getIsAuthenticated
	 */
	protected $authenticated = false;
	
	/**
	 * @var boolean whether is attributes was fetched.
	 */
	protected $fetched = false;
	
	/**
	 * @var EAuth the {@link EAuth} application component.
	 */
	private $component;
	
	/**
	 * @var string the redirect url after successful authorization.
	 */
	private $redirectUrl = '';
	
	/**
	 * @var string the redirect url after unsuccessful authorization (e.g. user canceled).
	 */
	private $cancelUrl = '';
	
		
	/**
	 * Initialize the component. 
	 * Sets the default {@link redirectUrl} and {@link cancelUrl}.
	 * @param EAuth $component the component instance.
	 * @param array $options properties initialization.
	 */
	public function init($component, $options = array()) {
		if (isset($component))
			$this->setComponent($component);
	
		foreach ($options as $key => $val)
			$this->$key = $val;
		
		$this->setRedirectUrl(Yii::app()->user->returnUrl);
		$server = Yii::app()->request->getHostInfo();
		$path = Yii::app()->request->getPathInfo();
		$this->setCancelUrl($server.'/'.$path);
	}
	
	/**
	 * Returns service name(id).
	 * @return string the service name(id).
	 */
	public function getServiceName() {
		return $this->name;
	}
	
	/**
	 * Returns service title.
	 * @return string the service title.
	 */
	public function getServiceTitle() {
		return $this->title;
	}
	
	/**
	 * Returns service type (e.g. OpenID, OAuth).
	 * @return string the service type (e.g. OpenID, OAuth). 
	 */
	public function getServiceType() {
		return $this->type;
	}
		
	/**
	 * Returns arguments for the jQuery.eauth() javascript function.
	 * @return array the arguments for the jQuery.eauth() javascript function. 
	 */
	public function getJsArguments() {
		return $this->jsArguments;
	}
	
	/**
	 * Sets {@link EAuth} application component
	 * @param EAuth $component the application auth component.
	 */
	public function setComponent($component) {
		$this->component = $component;
	}
	
	/**
	 * Returns the {@link EAuth} application component.
	 * @return EAuth the {@link EAuth} application component.
	 */
	public function getComponent() {
		return $this->component;
	}
	
	/**
	 * Sets redirect url after successful authorization.
	 * @param string url to redirect.
	 */
	public function setRedirectUrl($url) {
		$this->redirectUrl = $url;
	}
	
	/**
	 * Returns the redirect url after successful authorization.
	 * @return string the redirect url after successful authorization.
	 */
	public function getRedirectUrl() {
		return $this->redirectUrl;
	}
	
	/**
	 * Sets redirect url after unsuccessful authorization (e.g. user canceled).
	 * @param string url to redirect.
	 */
	public function setCancelUrl($url) {
		$this->cancelUrl = $url;
	}
	
	/**
	 * Returns the redirect url after unsuccessful authorization (e.g. user canceled).
	 * @return string the redirect url after unsuccessful authorization (e.g. user canceled).
	 */
	public function getCancelUrl() {
		return $this->cancelUrl;
	}
	
	/**
	 * Authenticate the user.
	 * @return boolean whether user was successfuly authenticated.
	 */
	public function authenticate() {		
		return $this->getIsAuthenticated();
	}
	
	/**
	 * Whether user was successfuly authenticated.
	 * @return boolean whether user was successfuly authenticated.
	 */
	public function getIsAuthenticated() {
        return $this->authenticated;
    }
	
	/**
	 * Redirect to the url. If url is null, {@link redirectUrl} will be used.
	 * @param string $url url to redirect.
	 */
	public function redirect($url = null) {
		$this->component->redirect(isset($url) ? $url : $this->redirectUrl, true);
	}
	
	/**
	 * Redirect to the {@link cancelUrl} or simply close the popup window.
	 */
	public function cancel($url = null) {
		$this->component->redirect(isset($url) ? $url : $this->cancelUrl, false);
	}
	
	/**
	 * Fetch attributes array.
	 */
	protected function fetchAttributes() {
		
	}
	
	/**
	 * Returns the user unique id.
	 * @return mixed the user id.
	 */
	public function getId() {
		return $this->getAttribute('id');
	}
	
	/**
	 * Returns the authorization attribute value.
	 * @param string $key the attribute name.
	 * @param mixed $default the default value.
	 * @return mixed the attribute value.
	 */
	public function getAttribute($key, $default = null) {
		if (!$this->fetched) {
			$this->fetchAttributes();
			$this->fetched = true;
		}
		return isset($this->attributes[$key]) ? $this->attributes[$key] : $default;
	}
	
	/**
	 * Whether the authorization attribute exists.
	 * @param string $key the attribute name.
	 * @return boolean true if attribute exists, false otherwise.
	 */
	public function hasAttribute($key) {
		return isset($this->attributes[$key]);
	}
	
	/**
	 * Returns the object with a human-readable representation of the current authorization.
	 * @return stdClass the object.
	 */
	public function getItem() {
		$item = new stdClass;
		$item->title = $this->getAttribute('name');
		if (empty($this->title))
			$item->title = $this->getId();
		if ($this->hasAttribute('url'))
			$item->url = $this->getAttribute('url');
		return $item;
	}
	
	/**
	 * Returns the array that contains all available authorization attributes.
	 * @return array the attributes.
	 */
	public function getItemAttributes() {
		$attributes = array();
		foreach ($this->attributes as $key => $val) {
			$attributes[$key] = $this->getAttribute($key);
		}
		return $attributes;
	}
}