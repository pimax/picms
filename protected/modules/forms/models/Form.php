<?php

/**
 * This is the model class for table "forms_forms".
 *
 * The followings are the available columns in table 'forms_forms':
 * @property integer $id
 * @property string $name
 * @property string $email_to
 * @property string $email_from
 * @property integer $template_id
 * @property integer $captcha
 * @property integer $send_email
 * @property string $button_text
 *
 * The followings are the available model relations:
 * @property FormsFields[] $formsFields
 * @property FormsResult[] $formsResults
 */
class Form extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Form the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'forms_forms';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('name', 'required'),
			array('template_id, captcha, send_email', 'numerical', 'integerOnly'=>true),
			array('name, email_to, email_from', 'length', 'max'=>255),
			array('button_text', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, email_to, email_from, template_id, captcha, send_email, button_text', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'formsFields' => array(self::HAS_MANY, 'FormsFields', 'form_id'),
			'formsResults' => array(self::HAS_MANY, 'FormsResult', 'form_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'email_to' => 'Отправитель',
			'email_from' => 'Получатель',
			'template_id' => 'Шаблон',
			'captcha' => 'Каптча',
			'send_email' => 'Отправлять результат на email',
			'button_text' => 'Текст кнопки отправки',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email_to',$this->email_to,true);
		$criteria->compare('email_from',$this->email_from,true);
		$criteria->compare('template_id',$this->template_id);
		$criteria->compare('captcha',$this->captcha);
		$criteria->compare('send_email',$this->send_email);
		$criteria->compare('button_text',$this->button_text,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}