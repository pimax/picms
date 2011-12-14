<?php

class DisconnectController extends FrontEndController
{
    public function actionIndex()
    {
        if (!Yii::app()->user->isGuest) {
            $service = Yii::app()->request->getQuery('service');
            if (isset($service)) {

                $oUser = UserModule::user();
                if ($service == 'facebook') {
                    $oUser->facebook_id = 0;
                } else if ($service == 'vkontakte') {
                    $oUser->vkontakte_id = 0;
                }
                $oUser->save();
                $this->redirect(array('/user/profile/edit'));
            }
        }
    }
}