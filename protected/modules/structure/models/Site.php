<?php

/**
 * This is the model class for table "structure_sites".
 *
 * The followings are the available columns in table 'structure_sites':
 * @property string $id
 * @property string $url
 * @property string $name
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property integer $template_id
 */
class Site extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Site the static model class
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
		return 'structure_sites';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('name, url', 'required'),
			array('url, name, meta_title', 'length', 'max'=>255),
			array('template_id, counters', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, url, name, meta_title', 'safe', 'on'=>'search'),
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
			'url' => 'Адрес',
			'name' => 'Название',
			'meta_title' => 'Заголовок',
            'template_id' => 'Шаблон',
            'counters' => 'Код счетчиков'
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
		$criteria->compare('url',$this->url,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('meta_title',$this->meta_title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}