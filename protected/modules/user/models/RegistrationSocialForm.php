<?php

class RegistrationSocialForm extends User
{
    public $first_name;
    public $last_name;
    public $email;
    public $username;
    public $password;
    public $avatar;
    
	public function rules() 
    {
		return array(
            array('username, password, first_name, email', 'required'),
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			array('email', 'email'),
            array('avatar, last_name', 'safe'),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
        );
	}
    
    public function attributeLabels()
	{
		return array(
			'username'=>UserModule::t("username"),
			'password'=>UserModule::t("password"),
			'email'=>UserModule::t("E-mail"),
			'first_name' => 'Имя',
			'last_name' => 'Фамилия',
			'avatar' => 'Изображение',
		);
	}
	
}