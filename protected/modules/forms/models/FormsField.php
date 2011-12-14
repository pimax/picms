<?php

/**
 * This is the model class for table "forms_fields".
 *
 * The followings are the available columns in table 'forms_fields':
 * @property integer $id
 * @property integer $form_id
 * @property string $field_type
 * @property string $name
 * @property string $alias
 * @property integer $pos
 * @property string $params
 * @property integer $required
 *
 * The followings are the available model relations:
 * @property FormsForms $form
 */
class FormsField extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return FormsField the static model class
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
		return 'forms_fields';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('form_id, pos, required', 'numerical', 'integerOnly'=>true),
			array('field_type, alias', 'length', 'max'=>45),
			array('name', 'length', 'max'=>255),
			array('params', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, form_id, field_type, name, alias, pos, params, required', 'safe', 'on'=>'search'),
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
			'form' => array(self::BELONGS_TO, 'FormsForms', 'form_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'form_id' => 'Form',
			'field_type' => 'Field Type',
			'name' => 'Name',
			'alias' => 'Alias',
			'pos' => 'Pos',
			'params' => 'Params',
			'required' => 'Required',
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
		$criteria->compare('form_id',$this->form_id);
		$criteria->compare('field_type',$this->field_type,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('params',$this->params,true);
		$criteria->compare('required',$this->required);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}