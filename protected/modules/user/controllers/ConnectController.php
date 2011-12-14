<?php

class ConnectController extends FrontEndController
{
    public function actionIndex()
    {
        if (!Yii::app()->user->isGuest) {
            $service = Yii::app()->request->getQuery('service');
            if (isset($service)) {
                $authIdentity = Yii::app()->eauth->getIdentity($service);
                $authIdentity->redirectUrl = $this->createAbsoluteUrl('/user/profile/edit');
                $authIdentity->cancelUrl = $this->createAbsoluteUrl('/user/profile/edit');

                if ($authIdentity->authenticate()) {
                    $identity = new ServiceUserIdentity($authIdentity);

                    // Успешный вход
                    if ($identity->authenticate()) {

                        $sField = $service == 'vkontakte' ? 'vkontakte_id' : 'facebook_id';
                        $oUserTest = User::model()->notsafe()->active()->find(array('condition' => $sField.'=:'.$sField, 'params' => array(':'.$sField => $identity->getState('social_id'))));
                        if ($oUserTest === null) {
                            $oUser = UserModule::user();
                            if ($service == 'facebook') {
                                $oUser->facebook_id = $identity->getState('social_id');
                            } else if ($service == 'vkontakte') {
                                $oUser->vkontakte_id = $identity->getState('social_id');
                            }
                            $oUser->save();
                        }
                        
                        

                        // Специальный редирект с закрытием popup окна
                        $authIdentity->redirect();
                    }
                    else {
                        // Закрываем popup окно и перенаправляем на cancelUrl
                        $authIdentity->cancel();
                    }
                }

                // Что-то пошло не так
                $this->redirect(array('/user/profile/edit'));
            }
        }
    }
}