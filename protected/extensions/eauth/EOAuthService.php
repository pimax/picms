<?php
/**
 * EOAuthService class file.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://code.google.com/p/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once 'EAuthServiceBase.php';

/**
 * EOAuthService is a base class for all OAuth providers.
 * @package application.extensions.eauth
 */
abstract class EOAuthService extends EAuthServiceBase implements IAuthService {
	
	/**
	 * @var EOAuthUserIdentity the OAuth library instance.
	 */
	private $auth;
	
		
	/**
	 * @var string OAuth2 client id. 
	 */
	protected $key;
	
	/**
	 * @var string OAuth2 client secret key.
	 */
	protected $secret;
	
	/**
	 * @var string OAuth scopes. 
	 */
	protected $scope = '';
	
	/**
	 * @var array Provider options. Must contain the keys: request, authorize, access.
	 */
	protected $providerOptions =  array(
		'request' => '',
		'authorize' => '',
		'access' => '',
	);
	
	
	/**
	 * Initialize the component.
	 * @param EAuth $component the component instance.
	 * @param array $options properties initialization.
	 */
	public function init($component, $options = array()) {		
		parent::init($component, $options);
		
		$this->auth = new EOAuthUserIdentity(array(
			'scope' => $this->scope,
			'key' => $this->key,
			'secret' => $this->secret,
			'provider' => $this->providerOptions,
		));
	}
	
	/**
	 * Authenticate the user.
	 * @return boolean whether user was successfuly authenticated.
	 */
	public function authenticate() {
		$this->authenticated = $this->auth->authenticate();
		return $this->getIsAuthenticated();
	}
	
	/**
	 * Returns the OAuth consumer.
	 * @return object the consumer.
	 */
	protected function getConsumer() {
		return $this->auth->getProvider()->consumer;
	}
	
	/**
	 * Returns the OAuth access token.
	 * @return string the token.
	 */
	protected function getAccessToken() {
		return $this->auth->getProvider()->token;
	}
	
	/**
	 * Returns the protected resource.
	 * @param string $url url to request.
	 * @param string $method the HTTP method to use.
	 * @param array $params request GET params.
	 * @return string the response. 
	 */
	protected function makeSignedRequest($url, $method = 'GET', $params = null) {
		if (!$this->getIsAuthenticated())
			throw new EAuthException(Yii::t('eauth', 'Unable to complete the authentication because the required data was not received.', array('{provider}' => ucfirst($this->serviceName))));
						
		$consumer = $this->getConsumer();
		$signatureMethod = new OAuthSignatureMethod_HMAC_SHA1();
		$token = $this->getAccessToken();

		$request = OAuthRequest::from_consumer_and_token($consumer, $token, $method, $url);
		$request->sign_request($signatureMethod, $consumer, $token);
		$url = $request->to_url();
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));

		if (isset($params)) {
			$data = OAuthUtil::build_http_query($params);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($tuCurl, CURLOPT_POSTFIELDS, $data); 
			curl_setopt($tuCurl, CURLOPT_HTTPHEADER, array("Content-Type: text/xml","SOAPAction: \"/soap/action/query\"", "Content-length: ".strlen($data))); 
		}
		
		$response = curl_exec($ch);
		$headers = curl_getinfo($ch);
		curl_close($ch);

		if ($headers['http_code'] != 200) {
			throw new EAuthException(Yii::t('eauth', 'Unable to complete the authentication because the required data was not received.', array('{provider}' => ucfirst($this->serviceName))), $headers['http_code']);
		}
		
		return $response;
	}
}