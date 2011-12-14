<?php

/**
 * This is the model class for table "main_modules".
 *
 * The followings are the available columns in table 'main_modules':
 * @property string $id
 * @property string $name
 * @property string $module_alias
 * @property string $description
 * @property integer $installed
 */
class ModulesItem extends CActiveRecord
{
    private static $_items=array();
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return ModulesItem the static model class
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
		return 'main_modules';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('name, module_alias', 'required'),
			array('installed', 'numerical', 'integerOnly'=>true),
			array('name, module_alias', 'length', 'max'=>255),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, module_alias, description, installed', 'safe', 'on'=>'search'),
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
			'module_alias' => 'Системное имя',
			'description' => 'Описание',
			'installed' => 'Установлен',
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
		$criteria->compare('module_alias',$this->module_alias,true);

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