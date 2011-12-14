<?php

/**
 * This is the model class for table "publications_categories".
 *
 * The followings are the available columns in table 'publications_categories':
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property integer $tree_parent_id
 * @property integer $tree_level
 */
class PublicationsCategory extends CActiveRecord
{
    private static $_items=array();
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return PublicationsCategory the static model class
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
		return 'publications_categories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, alias', 'required'),
			array('title, alias', 'length', 'max'=>128),
            array('alias', 'unique', 'allowEmpty' => false, 'caseSensitive' => true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, alias', 'safe', 'on'=>'search'),
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
            'posts' => array(self::HAS_MANY, 'PublicationsPost', 'category_id', 'condition'=>'posts.status='.PublicationsPost::STATUS_PUBLISHED, 'order'=>'posts.create_time DESC'),
			'postCount' => array(self::STAT, 'PublicationsPost', 'category_id', 'condition'=>'status='.  PublicationsPost::STATUS_PUBLISHED),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Название',
			'alias' => 'Постоянная ссылка',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('alias',$this->alias,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function getUrl()
	{
        if (Yii::app() instanceof CmsApplication) {
            return '/wave/'.$this->alias;
        } else {
            return false;
        }
	}
    
	public static function items()
	{
		if(!count(self::$_items)) {
			self::loadItems();
        }
        
		return self::$_items;
	}
    
    public static function item($id)
	{
		if(!count(self::$_items)) {
			self::loadItems();
        }
        
		return isset(self::$_items[$id]) ? self::$_items[$id] : false;
	}

	private static function loadItems()
	{
		self::$_items = array();
        
		$models = self::model()->findAll();
		foreach($models as $model) {
			self::$_items[$model->id] = $model->title;
        }
        
        return true;
	}
}