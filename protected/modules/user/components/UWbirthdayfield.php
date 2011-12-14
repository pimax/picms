<?php

class UWbirthdayfield {
	
	/**
	 * @var array
	 */
	public $params = array();
	
	/**
	 * Initialization
	 * @return array
	 */
	public function init() {
		return array(
			'name'=>__CLASS__,
			'label'=> 'Birthday',
			'fieldType'=>array('DATE','VARCHAR'),
			'params'=>$this->params,
			'paramsLabels' => array(
				'dateFormat'=>UserModule::t('Date format'),
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
		//if ($value=='0000-00-00') $value = '';
        $value = '';
        
        if (isset($values[$field_varname.'_year'])) {
            $value .= $values[$field_varname.'_year'];
        } else {
            $value .= '0000';
        }
        
        if (isset($values[$field_varname.'_month'])) {
            $value .= '-'.$values[$field_varname.'_month'];
        } else {
            $value .= '-00';
        }
        
        if (isset($values[$field_varname.'_day'])) {
            $value .= '-'.$values[$field_varname.'_day'];
        } else {
            $value .= '-00';
        }
        //echo $value;die();
        
        if ($value=='0000-00-00') $value = '';
        
		return $value;
	}
	
	/**
	 * @param $model - profile model
	 * @param $field - profile fields model item
	 * @return string
	 */
	public function viewAttribute($model,$field) {
		return Pi::showDate($model->getAttribute($field->varname));
	}
	
	/**
	 * @param $model - profile model
	 * @param $field - profile fields model item
	 * @param $params - htmlOptions
	 * @return string
	 */
	public function editAttribute($model,$field,$htmlOptions=array()) {
		if (!isset($htmlOptions['size'])) $htmlOptions['size'] = 60;
		if (!isset($htmlOptions['maxlength'])) $htmlOptions['maxlength'] = (($field->field_size)?$field->field_size:10);
		if (!isset($htmlOptions['id'])) $htmlOptions['id'] = get_class($model).'_'.$field->varname;
		
        $sResult = '';
		
        $aDays = array('00' => 'день');
        for ($i = 1; $i <= 31 ; $i++) {
            if ($i < 10) {
                $aDays['0'.$i] = '0'.$i;
            } else {
                $aDays[$i] = $i;        
            }
        }
        
        $aMonths = array(
            '00' => 'месяц',
			'01' => 	'январь',
			'02' => 	'февраль',
			'03' => 	'март',
			'04' => 	'апрель',
			'05' => 	'май',
			'06' => 	'июнь',
			'07' => 	'июль',
			'08' => 	'август',
			'09' => 	'сентябрь',
			'10' => 	'октябрь',
			'11' => 	'ноябрь',
			'12' => 	'декабрь');
        
        $aYears = array('0000' => 'год');
        for ($i = date("Y"); $i >= 1900 ; $i--) {
            $aYears[$i] = $i; 
        }
        
        $sOldDate = $model->getAttribute($field->varname);
        $aOldDate = explode("-", $sOldDate);
        
        if (isset($_POST[get_class($model)][$field->varname.'_day'])) {
            $sDay = $_POST[get_class($model)][$field->varname.'_day'];
        } else {
            $sDay = $aOldDate[2];
        }
        
        if (isset($_POST[get_class($model)][$field->varname.'_month'])) {
            $sMonth = $_POST[get_class($model)][$field->varname.'_month'];
        } else {
            $sMonth = $aOldDate[1];
        }
        
        if (isset($_POST[get_class($model)][$field->varname.'_year'])) {
            $sYear = $_POST[get_class($model)][$field->varname.'_year'];
        } else {
            $sYear = $aOldDate[0];
        }
         
        $sResult.= CHtml::hiddenField(get_class($model).'['.$field->varname.']', '0000-00-00');
        $sResult.= CHtml::dropDownList(get_class($model).'['.$field->varname.'_day]', $sDay, $aDays,array()).'&nbsp;';
        $sResult.= CHtml::dropDownList(get_class($model).'['.$field->varname.'_month]', $sMonth, $aMonths,array()).'&nbsp;';
        $sResult.= CHtml::dropDownList(get_class($model).'['.$field->varname.'_year]', $sYear, $aYears,array());
        
        
        
		
		return $sResult;
	}
	
}