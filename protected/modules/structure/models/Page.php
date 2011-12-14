<?php

/**
 * This is the model class for table "structure_pages".
 *
 * The followings are the available columns in table 'structure_pages':
 * @property string $id
 * @property integer $lft
 * @property integer $rgt
 * @property integer $level
 * @property integer $type_id
 * @property string $url
 * @property string $path
 * @property string $name
 * @property string $header
 * @property string $meta_title
 * @property string $content
 * @property string $meta_keywords
 * @property string $meta_description
 * @property integer $site_id
 */
class Page extends CActiveRecord
{
    public $parentId;
    
    public function behaviors()
    {
        return array(
            'tree'=>array(
                'class'=>'ext.yiiext.behaviors.model.trees.NestedSetBehavior',
                'leftAttribute'=>'lft',
                'rightAttribute'=>'rgt',
                'levelAttribute'=>'level',
            )
        );
    }

	/**
	 * Returns the static model of the specified AR class.
	 * @return Page the static model class
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
		return 'structure_pages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('name, type_id, site_id, url', 'required'),
			array('type_id, site_id, update_time', 'numerical', 'integerOnly'=>true),
			array('url, name, header, meta_title', 'length', 'max'=>255),
            array('title_in_menu', 'length', 'max'=>255),
			array('path', 'length', 'max'=>1000),
            array('url', 'unique', 'allowEmpty' => false, 'caseSensitive' => true),
			array('content, template_id, allow_index, show_in_menu, show_in_sitemap', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type_id, url, name, header, meta_title, content, meta_keywords, meta_description, site_id', 'safe', 'on'=>'search'),
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
            'site' => array(self::BELONGS_TO, 'Site', 'site_id'),
            'type' => array(self::BELONGS_TO, 'StructureType', 'type_id'),
            'template' => array(self::BELONGS_TO, 'Template', 'template_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',			
			'type_id' => 'Тип контента',
			'url' => 'Постоянная ссылка',
			'path' => 'Путь',
			'name' => 'Название',
			'header' => 'Заголовок (H1)',
			'meta_title' => 'Заголовок',
			'content' => 'Контент',
			'template_id' => 'Шаблон',
			'meta_keywords' => 'Ключевые слова',
			'meta_description' => 'Описание',
			'site_id' => 'Сайт',
            'parentId' => 'Родитель',
            'title_in_menu' => 'Название в меню',
            'allow_index' => 'Индексировать',
            'show_in_menu' => 'Отображать в меню',
            'show_in_sitemap' => 'Отображать в карте сайта'
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
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('header',$this->header,true);
		$criteria->compare('meta_title',$this->meta_title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('meta_keywords',$this->meta_keywords,true);
		$criteria->compare('meta_description',$this->meta_description,true);
		$criteria->compare('site_id',$this->site_id);
        
        $criteria->order = $this->tree->hasManyRoots ? $this->tree->rootAttribute . ', ' . $this->tree->leftAttribute : $this->tree->leftAttribute;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            
		));
	}
    
    public function getNameExt()
    {
        return str_repeat('---', $this->level - 1).' '.$this->name;
    }
    
    public static function getPagesListData()
    {
        $data = CHtml::listData(self::model()->findAll(array('order'=>'lft')), 'id', 'nameExt');
        
        return $data;
    }   
    
    public static function getPathForPage(Page $oPage)
    {
        $sPath = $oPage->url;
        
        $oParent = $oPage->parent;
        
        if ($oParent) {
            if ($oParent->isRoot()) {
                return '/'.$sPath;
            } else {
                return $oParent->path.'/'.$sPath;
            }
        }
        
        return $sPath;
    }
    
    /**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
            $this->update_time=time();
            
			return true;
		}
		else
			return false;
	}
}