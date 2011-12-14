<?php
/**
 * VKontakteOAuthService class file.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://code.google.com/p/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once dirname(dirname(__FILE__)).'/EOAuth2Service.php';

/**
 * VKontakte provider class.
 * @package application.extensions.eauth.services
 */
class VKontakteOAuthService extends EOAuth2Service {	
	
	protected $name = 'vkontakte';
	protected $title = 'ВКонтакте';
	protected $type = 'OAuth';
	protected $jsArguments = array('popup' => array('width' => 824, 'height' => 500));

	protected $client_id = '';
	protected $client_secret = '';
	protected $scope = '';
	protected $providerOptions = array(
		'authorize' => 'http://api.vkontakte.ru/oauth/authorize',
		'access_token' => 'https://api.vkontakte.ru/oauth/access_token',
	);
	
	protected function fetchAttributes() {
		$info = (array)$this->makeSignedRequest('https://api.vkontakte.ru/method/getProfiles', array(
			'uids' => $this->getUid(),
			'fields' => 'screen_name,photo_big', // uid, first_name and last_name is always available
			//'fields' => 'nickname, sex, bdate, city, country, timezone, photo, photo_medium, photo_big, photo_rec',
		));

		$info = $info['response'][0];

		$this->attributes['id'] = $info->uid;
		$this->attributes['name'] = $info->first_name.' '.$info->last_name;
		$this->attributes['first_name'] = $info->first_name;
		$this->attributes['last_name'] = $info->last_name;
		
		if (!empty($info->screen_name)) {
            $this->attributes['url'] = 'http://vkontakte.ru/'.$info->screen_name;
			$this->attributes['username'] = $info->screen_name;
        } else {
            $this->attributes['url'] = 'http://vkontakte.ru/id'.$info->uid;
			$this->attributes['username'] = 'id'.$info->uid;
        }
        
        $this->attributes['photo_big'] = $info->photo_big;
        $this->attributes['email'] = '';
		
		//$this->attributes['gender'] = $info->sex == 1 ? 2 : 1;
		
		//$this->attributes['city'] = $info->city;
		//$this->attributes['country'] = $info->country;
		
		//$this->attributes['timezone'] = timezone_name_from_abbr('', $info->timezone*3600, date('I'));;
		
		//$this->attributes['photo'] = $info->photo;
		//$this->attributes['photo_medium'] = $info->photo_medium;
		
		//$this->attributes['photo_rec'] = $info->photo_rec;
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
				throw new EAuthException('Invalid response format.', 500);
			}
			else if (isset($result->error, $result->error_description)) {
				throw new EAuthException($result->error_description, 500);
			}
			else
				return $result;
		}
		catch(Exception $e) {
			throw new EAuthException($e->getMessage(), $e->getCode(), $e->getPrevious());
		}
		
	}
	
	protected function getUid() {
		$session = Yii::app()->session;
		if (!isset($session['__eauth_vk_user_id'])) {
			//$session_key = 'oauth2_token_'.$this->getServiceName();
			//unset($session[$session_key]);
			//Yii::app()->request->redirect(Yii::app()->getRequest()->getUrl());
			throw new EAuthException('Unable to get vkontakte user id.', 500);
		}
		return $session['__eauth_vk_user_id'];
	}
	
	protected function getAccessToken($code) {
		$result = parent::getAccessToken($code);
		$session = Yii::app()->session;
		$session['__eauth_vk_user_id'] = $result->user_id;
		return $result->access_token;
	}
	
	protected function getCodeUrl($redirect_uri) {
		$url = parent::getCodeUrl($redirect_uri);
		//if (isset($_GET['js']))
			//$url .= '&display=popup';
		return $url;
	}
}