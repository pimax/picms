<?php

class RegistrationSocialController extends FrontEndController
{
    public function actionIndex()
    {
        $model = new RegistrationSocialForm;
        $session =  Yii::app()->session;
        $model->username = $session['social_username'];
        $model->password = Yii::app()->getModule('user')->genPasswd();
        
        if(isset($_POST['RegistrationSocialForm']))
        {
            $model->attributes = $_POST['RegistrationSocialForm'];
            if($model->validate()) {
                
                /**
                 *  Регистрация, авторизация, отправка письма на почту
                 */
                $profile = new Profile;
                $profile->regMode = true;
                $profile->firstname = $model->first_name;
                $profile->lastname = $model->last_name;
                
                if ($session['social_photo_big']) {
                    $sFile = file_get_contents($session['social_photo_big']);
                    $sFileName = Yii::app()->params['uploadsImagesPath'].'/users/'.time().'.jpg';
                    $profile->avatar = 'users/'.time().'.jpg';
                    file_put_contents($sFileName, $sFile);
                }
                
                if (Yii::app()->user->id) {
                    $this->redirect(Yii::app()->controller->module->profileUrl);
                } else {
                    $user = new User;
                    $soucePassword = $model->password;
                    $user->username = $model->username;
                    $user->email = $model->email;
                    $user->activkey=UserModule::encrypting(microtime().$model->password);
                    $user->password=UserModule::encrypting($model->password);
                    $user->createtime=time();
                    $user->lastvisit=time();
                    $user->superuser=0;
                    $user->status=User::STATUS_ACTIVE;
                    
                    $user->vkontakte_id = isset($session['social_vkontakte_id']) ? $session['social_vkontakte_id'] : 0;
                    $user->facebook_id = isset($session['social_facebook_id']) ? $session['social_facebook_id'] : 0;
                    
                    if (!$user->validate()) {
                        $user->username .= time();
                    }

                    if ($user->save()) {
                        $profile->user_id = $user->id;
                        $profile->save();
                        
                        Yii::app()->mailer->ClearAddresses();
                        Yii::app()->mailer->From = Yii::app()->params['adminEmail'];
                        Yii::app()->mailer->FromName = Yii::app()->getSite()->name;
                        Yii::app()->mailer->AddAddress($model->email);
                        Yii::app()->mailer->Subject = UserModule::t("You registered from {site_name}",array('{site_name}'=>Yii::app()->getSite()->name));
                        Yii::app()->mailer->SetHtmlBody('registrationSocial', array('email' => $model->email, 'username' => $model->username, 'password' => $soucePassword));
                        Yii::app()->mailer->Send();

                        //UserModule::sendMail($model->email,UserModule::t("You registered from {site_name}",array('{site_name}'=>Yii::app()->getSite()->name)),UserModule::t("Login: {username} Password: {password}",array('{username}'=>$user->username, '{password}' => $soucePassword)));

                        $identity=new UserIdentity($user->username,$soucePassword);
                        $identity->authenticate();
                        Yii::app()->user->login($identity,0);
                        
                        unset($session['social_first_name']);
                        unset($session['social_last_name']);
                        unset($session['social_email']);
                        unset($session['social_photo_big']);
                        unset($session['social_username']);
                        unset($session['social_vkontakte_id']);
                        unset($session['social_facebook_id']);
                        
                        $this->redirect(Yii::app()->controller->module->returnUrl);
                    }
                }
            }
        } else {
            
            $model->first_name = $session['social_first_name'];
            $model->last_name = $session['social_last_name'];            
        }
        
        // display the login form
        $this->render('index', array('model'=>$model));
    }
}