<?php

class UWimage {
	
	/**
	 * @var array
	 * @name widget parametrs
	 */
	public $params = array('path'=>'users');
	
	/**
	 * Widget initialization
	 * @return array
	 */
	public function init() {
		return array(
			'name'=>__CLASS__,
			'label'=> 'Image field',
			'fieldType'=>array('VARCHAR'),
			'params'=>$this->params,
			'paramsLabels' => array(
				'path'=>UserModule::t('Upload path'),
			),
			'other_validator'=>array(
				'file'=>array(
					'allowEmpty'=>array('','false','true'),
					'maxFiles'=>'',
					'maxSize'=>'',
					'minSize'=>'',
					'tooLarge'=>'',
					'tooMany'=>'',
					'tooSmall'=>'',
					'types'=>'',
					'wrongType'=>'',
				),
			),
		);
	}
	
	/**
	 * @param $value
	 * @param $model
	 * @param $field_varname
	 * @return string
	 */
	public function setAttributes($value,$model,$field_varname, $values) {
		$value = CUploadedFile::getInstance($model,$field_varname);
		
		if ($value) {
			$old_file = $model->getAttribute($field_varname);
			$file_name = $this->params['path'].'/'.$value->name;
            
			if (file_exists(Yii::app()->params['uploadsImagesPath'].'/'.$file_name)) {
				$file_name = str_replace('.'.$value->extensionName,'-'.time().'.'.$value->extensionName,$file_name);
			}
            
            //echo '<pre>', print_r($model, true); die();
			//if ($model->validate()) {
				if ($old_file&&file_exists(Yii::app()->params['uploadsImagesPath'].'/'.$old_file))
					unlink(Yii::app()->params['uploadsImagesPath'].'/'.$old_file);
                
               // echo Yii::app()->params['uploadsImagesPath'].'/'.$file_name; die();
				$value->saveAs(Yii::app()->params['uploadsImagesPath'].'/'.$file_name);
			//}
			$value = $file_name;
		} else {
			if (isset($_POST[get_class($model)]['uwfdel'][$field_varname])&&$_POST[get_class($model)]['uwfdel'][$field_varname]) {
				$old_file = $model->getAttribute($field_varname);
				if ($old_file&&file_exists(Yii::app()->params['uploadsImagesPath'].'/'.$old_file))
					unlink(Yii::app()->params['uploadsImagesPath'].'/'.$old_file);
				$value='';
			} else {
				$value = $model->getAttribute($field_varname);
			}
		}
		return $value;
	}
		
	/**
	 * @param $value
	 * @return string
	 */
	public function viewAttribute($model,$field) {
		$file = $model->getAttribute($field->varname);
		if ($file) {
            return '<img src="'.Pi::getThumbUrl('/'.$file, 100).'" />';
		} else
			return '';
	}
		
	/**
	 * @param $value
	 * @return string
	 */
	public function editAttribute($model,$field,$params=array()) {
		if (!isset($params['options'])) $params['options'] = array();
		$options = $params['options'];
		unset($params['options']);
		unset($params['class']);
		
        $sResult = '';
        $file = $model->getAttribute($field->varname);
		if ($file) {
            $sResult .= '<img src="'.Pi::getThumbUrl('/'.$file, 100).'" /><br /><div style="margin-left:140px">';
		}
        
		$sResult .= CHtml::activeFileField($model,$field->varname,$params)
		.(($model->getAttribute($field->varname))?'<br/>'.CHtml::activeCheckBox($model,'[uwfdel]'.$field->varname,$params)
		.' '.CHtml::activeLabelEx($model,'[uwfdel]'.$field->varname,array('label'=>UserModule::t('Delete file'),'class' => 'inline')):'')
		;
        
        if ($file) {
           $sResult.='</div>';
        }
        
        return $sResult;
	}
	
}