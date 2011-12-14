<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';
    
    public function filters()
    {
        return array();
    }

    public function init()
    {
        if (!Yii::app() instanceof CmsApplication) {
            $this->layout = "//layouts/simple";
        }
        
        parent::init();
    }
    
	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (Yii::app()->user->isGuest) {
            
            $service = Yii::app()->request->getQuery('service');
            if (isset($service)) {
                $authIdentity = Yii::app()->eauth->getIdentity($service);
                $authIdentity->redirectUrl = $this->createAbsoluteUrl('/');
                $authIdentity->cancelUrl = $this->createAbsoluteUrl('/user/login');

                if ($authIdentity->authenticate()) {
                    $identity = new ServiceUserIdentity($authIdentity);

                    // Успешный вход
                    if ($identity->authenticate()) {
                        //Yii::app()->user->login($identity);
                        
                        /**
                         * 1. Ищем пользователя в БД, у которого коннект с аккаунтом соц сети
                         * 2. Если находим, то авторизовываемся под ним
                         * 3. Если нет, то в state сохраняем имя, фамилию, email, фотку пользователя
                         * 4. Открываем страницу регистрации, поля уже заполнены
                         * 5. Сохраняем пользователя, и отправялем письмо с паролем на мыло
                         */
                        
                        /**
                         * Ищем пользователя в БД, у которого коннект с аккаунтом соц сети,
                         * Если находим, то авторизовываемся под ним,
                         * Если нет, то регаем чувака
                         */
                        $sField = $service == 'vkontakte' ? 'vkontakte_id' : 'facebook_id';
                        $oUser = User::model()->notsafe()->active()->find(array('condition' => $sField.'=:'.$sField, 'params' => array(':'.$sField => $identity->getState('social_id'))));
                        if ($oUser) {
                            $identity2 = new UserIdentity($oUser->username, $oUser->password, true);
                            $identity2->authenticate();
                            Yii::app()->user->login($identity2, 0);
                            
                            $authIdentity->redirect();
                        } else {
                            /**
                             * Поля:
                             * - Имя first_name
                             * - Фамилия last_name
                             * - E-mail email
                             * Фотка загружена и обрезана автоматом photo_big
                             */
                            //$identity->getState('id');
                            //echo '<pre>', print_r(Yii::app()->session, true), '</pre>';
                            //echo $identity->getState('username');die();
                            
                            $this->redirect(array('/user/registrationSocial'));
                        }
                        

                        // Специальный редирект с закрытием popup окна
                        //$authIdentity->redirect();
                    }
                    else {
                        // Закрываем popup окно и перенаправляем на cancelUrl
                        $authIdentity->cancel();
                    }
                }

                // Что-то пошло не так, перенаправляем на страницу входа
                $this->redirect(array('/user/login'));
            }
            
            
			$model=new UserLogin;
			// collect user input data
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($model->validate()) {
					$this->lastViset();
					if (strpos(Yii::app()->user->returnUrl,'/index.php')!==false)
						$this->redirect(Yii::app()->controller->module->returnUrl);
					else
						$this->redirect(Yii::app()->user->returnUrl);
				}
			}
			// display the login form
			$this->render('/user/login',array('model'=>$model));
		} else
			$this->redirect(Yii::app()->controller->module->returnUrl);
	}
	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit = time();
		$lastVisit->save();
	}

}