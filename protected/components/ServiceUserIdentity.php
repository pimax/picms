<?php

class ServiceUserIdentity extends UserIdentity 
{
    const ERROR_NOT_AUTHENTICATED = 3;

    /**
     * @var EAuthServiceBase the authorization service instance.
     */
    protected $service;
    
    /**
     * Constructor.
     * @param EAuthServiceBase $service the authorization service instance.
     */
    public function __construct($service) 
    {
        $this->service = $service;
    }
    
    /**
     * Authenticates a user based on {@link username}.
     * This method is required by {@link IUserIdentity}.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() 
    {        
        if ($this->service->isAuthenticated) {
            $this->username = $this->service->getAttribute('username');
            $this->setState('social_id', $this->service->id);
            $this->setState('social_first_name', $this->service->getAttribute('first_name'));
            $this->setState('social_last_name', $this->service->getAttribute('last_name'));
            $this->setState('social_email', $this->service->getAttribute('email'));
            $this->setState('social_photo_big', $this->service->getAttribute('photo_big'));
            $this->setState('social_username', $this->username);
            $this->setState('social_service', $this->service->serviceName);
            
            $session = Yii::app()->session;
            $session['social_first_name'] = $this->service->getAttribute('first_name');
            $session['social_last_name'] = $this->service->getAttribute('last_name');
            $session['social_email'] = $this->service->getAttribute('email');
            $session['social_photo_big'] = $this->service->getAttribute('photo_big');
            $session['social_username'] = $this->service->getAttribute('username');
            $session['social_'.$this->service->serviceName.'_id'] = $this->service->id;
            
            $this->errorCode = self::ERROR_NONE;        
        }
        else {
            $this->errorCode = self::ERROR_NOT_AUTHENTICATED;
        }
        return !$this->errorCode;
    }
}