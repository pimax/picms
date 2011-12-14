<?php

/**
 * This is the model class for table "structure_types".
 *
 * The followings are the available columns in table 'structure_types':
 * @property string $id
 * @property string $name
 * @property integer $module_id
 * @property string $controller_alias
 * @property string $action_alias
 * @property string $description
 * @property string $params
 */
class StructureType extends CActiveRecord
{
    private static $_items=array();
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return StructureTypes the static model class
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
		return 'structure_types';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('name, module_id, controller_alias', 'required'),
			array('module_id', 'numerical', 'integerOnly'=>true),
			array('name, controller_alias, action_alias', 'length', 'max'=>255),
			array('description, params', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, module_id, controller_alias, action_alias, description, params', 'safe', 'on'=>'search'),
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
            'module' => array(self::BELONGS_TO, 'ModulesItem', 'module_id'),
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
			'module_id' => 'Модуль',
			'controller_alias' => 'Контроллер',
			'action_alias' => 'Действие',
			'description' => 'Описание',
			'params' => 'Параметры',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('module_id',$this->module_id);
		$criteria->compare('controller_alias',$this->controller_alias,true);
		$criteria->compare('action_alias',$this->action_alias,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('params',$this->params,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public static function items($bWithNone = false)
	{
		if(empty(self::$_items)) {
			self::loadItems();
        }
        
        if ($bWithNone) {
            return array("" => 'Не выбрано') + self::$_items;
        } else {
            return self::$_items;
        }
	}
    
    public static function item($id)
	{
		if(empty(self::$_items)) {
			self::loadItems();
        }
        
		return isset(self::$_items[$id]) ? self::$_items[$id] : false;
	}
    
    private static function loadItems()
	{
		self::$_items = array();
		$models = self::model()->findAll(array(			
			'order'=>'id',
		));
        
		foreach($models as $model) {
			self::$_items[$model->id]=$model->name;
        }
	}
}