<?php
/**
 * FacebookOAuthService class file.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://code.google.com/p/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once dirname(dirname(__FILE__)).'/EOAuth2Service.php';

/**
 * Facebook provider class.
 * @package application.extensions.eauth.services
 */
class FacebookOAuthService extends EOAuth2Service {	
	
	protected $name = 'facebook';
	protected $title = 'Facebook';
	protected $type = 'OAuth';
	protected $jsArguments = array('popup' => array('width' => 980, 'height' => 500));

	protected $client_id = '';
	protected $client_secret = '';
	protected $scope = '';
	protected $providerOptions = array(
		'authorize' => 'https://www.facebook.com/dialog/oauth',
		'access_token' => 'https://graph.facebook.com/oauth/access_token',
	);
	
	protected function fetchAttributes() {
		$info = (object) $this->makeSignedRequest('https://graph.facebook.com/me');

		$this->attributes['id'] = $info->id;
		$this->attributes['name'] = $info->name;
		$this->attributes['first_name'] = $info->first_name;
		$this->attributes['last_name'] = $info->last_name;
		$this->attributes['url'] = $info->link;
		$this->attributes['username'] = property_exists($info, 'username') ? $info->username : 'facebook'.$info->id;
		$this->attributes['photo_big'] = 'http://graph.facebook.com/'.$info->username.'/picture?type=large';
        $this->attributes['email'] = property_exists($info, 'email') ? $info->email : '';
	}
		
	public function authenticate() {
		if (isset($_GET['error'], $_GET['error_reason']) && $_GET['error'] == 'access_denied' && $_GET['error_reason'] == 'user_denied')
			$this->cancel();
		else
			return parent::authenticate();
	}
	
	protected function makeRequest($url, $callbackurl = '') {
		try {
			$response = parent::makeRequest($url, $callbackurl);
			
			$result = json_decode($response);
			if (!isset($result)) {
				parse_str($response, $result);
				$keys = array_keys($result);
				if (count($result) == 1 && array_pop($keys) == $response) {
					throw new EAuthException('Invalid response format.', 500);
				}
			}
			
			if (isset($result->error)) {
				throw new EAuthException($result->error->message, 500);
			}
			else
				return (object) $result;
		}
		catch(Exception $e) {
			throw new EAuthException($e->getMessage(), $e->getCode());
		}
	}
	
	protected function getTokenUrl($code) {
		$session = Yii::app()->session;
		return parent::getTokenUrl($code).'&redirect_uri='.urldecode($session['__eauth_facebook_redirect_uri']);
	}
	
	protected function getAccessToken($code) {
		$result = parent::getAccessToken($code);
		return $result->access_token;
	}
	
	protected function getCodeUrl($redirect_uri) {
		$session = Yii::app()->session;
		$session['__eauth_facebook_redirect_uri'] = $redirect_uri;
		$url = parent::getCodeUrl($redirect_uri);
		if (isset($_GET['js']))
			$url .= '&display=popup';
		return $url;
	}
}