<?php

class RecoveryController extends Controller
{
	public $defaultAction = 'recovery';
	
    public function init()
    {
        if (!Yii::app() instanceof CmsApplication) {
            $this->layout = "//layouts/simple";
        }
        
        parent::init();
    }
    
	/**
	 * Recovery password
	 */
	public function actionRecovery () {
		$form = new UserRecoveryForm;
		if (Yii::app()->user->id) {
		    	$this->redirect(Yii::app()->controller->module->returnUrl);
		    } else {
				$email = ((isset($_GET['email']))?$_GET['email']:'');
				$activkey = ((isset($_GET['activkey']))?$_GET['activkey']:'');
				if ($email&&$activkey) {
					$form2 = new UserChangePassword;
		    		$find = User::model()->notsafe()->findByAttributes(array('email'=>$email));
		    		if(isset($find)&&$find->activkey==$activkey) {
			    		if(isset($_POST['UserChangePassword'])) {
							$form2->attributes=$_POST['UserChangePassword'];
							if($form2->validate()) {
								$find->password = Yii::app()->controller->module->encrypting($form2->password);
								$find->activkey=Yii::app()->controller->module->encrypting(microtime().$form2->password);
								if ($find->status==0) {
									$find->status = 1;
								}
								$find->save();
								Yii::app()->user->setFlash('recoveryMessage',UserModule::t("New password is saved."));
								$this->redirect(Yii::app()->controller->module->recoveryUrl);
							}
						} 
						$this->render('changepassword',array('form'=>$form2));
		    		} else {
		    			Yii::app()->user->setFlash('recoveryMessage',UserModule::t("Incorrect recovery link."));
						$this->redirect(Yii::app()->controller->module->recoveryUrl);
		    		}
		    	} else {
			    	if(isset($_POST['UserRecoveryForm'])) {
			    		$form->attributes=$_POST['UserRecoveryForm'];
			    		if($form->validate()) {
			    			$user = User::model()->notsafe()->findbyPk($form->user_id);
							$activation_url = 'http://' . $_SERVER['HTTP_HOST'].$this->createUrl(implode(Yii::app()->controller->module->recoveryUrl),array("activkey" => $user->activkey, "email" => $user->email));
							
                            Yii::app()->mailer->ClearAddresses();
                            Yii::app()->mailer->From = Yii::app()->params['adminEmail'];
                            Yii::app()->mailer->FromName = Yii::app()->getSite()->name;
                            Yii::app()->mailer->AddAddress($user->email);
                            Yii::app()->mailer->Subject = UserModule::t("You have requested the password recovery site {site_name}",array('{site_name}'=>Yii::app()->getSite()->name));
                            Yii::app()->mailer->SetHtmlBody('recovery', array('link' => $activation_url));
                            Yii::app()->mailer->Send();
                            
                            			    			
							Yii::app()->user->setFlash('recoveryMessage',UserModule::t("Please check your email. An instructions was sent to your email address."));
			    			$this->refresh();
			    		}
			    	}
		    		$this->render('recovery',array('form'=>$form));
		    	}
		    }
	}

}