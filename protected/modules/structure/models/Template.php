<?php

/**
 * This is the model class for table "structure_templates".
 *
 * The followings are the available columns in table 'structure_templates':
 * @property string $id
 * @property string $name
 * @property string $layout
 * @property string $description
 * @property integer $part_template
 */
class Template extends CActiveRecord
{
    private static $_items=array();
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return Template the static model class
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
		return 'structure_templates';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, layout', 'required'),
			array('name, layout', 'length', 'max'=>255),
            array('part_template', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name', 'safe', 'on'=>'search'),
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
			'layout' => 'Layout',
			'description' => 'Описание',
			'part_template' => 'Часть шаблона',
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
		$criteria->compare('layout',$this->layout,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public static function getLayouts($bWithNone = false)
    {
        $path = Yii::app()->basePath.'/views/frontend/layouts';
        
        if ($bWithNone) {
            return array("" => "Наследовать") + self::getTemplates($path);
        } else {
            return self::getTemplates($path);
        }    
    }
 
    
    public static function getTemplates($path)
    {   
        $aResult = array();
        
        if (false !== ($handle = opendir($path)))
        {
            while (false !== ($file = readdir($handle)))
            {
                if ($file{0} == '.') continue;
                $aName = explode('.', $file);
                if (is_file($path.DIRECTORY_SEPARATOR.$file))
                {            
                    $aResult[$aName[0]] = $aName[0];
                }                
            }
            closedir($handle);
        
        }
        
        return $aResult;
    }
    
    public function getTemplateData()
    {
        
        $path = Yii::app()->basePath.'/views/frontend/layouts/'.$this->layout.'.php';
        if (file_exists($path)) {
            return file_get_contents($path);
        }
        
        return '';
    }
    
    public static function items($bWithNone = false)
	{
		if(empty(self::$_items)) {
			self::loadItems();
        }
        
        if ($bWithNone) {
            return array("" => 'Наследовать') + self::$_items;
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
            'condition' => 'part_template = 0',
			'order'=>'id',
		));
        
		foreach($models as $model) {
			self::$_items[$model->id]=$model->name;
        }
	}
    
    protected function afterDelete()
	{
		parent::afterDelete();
		
        $path = Yii::app()->basePath.'/views/frontend/layouts/'.$this->layout.'.php';
        unlink($path);
	}
}