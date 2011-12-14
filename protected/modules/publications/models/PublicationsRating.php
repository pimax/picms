<?php

/**
 * This is the model class for table "publications_rating".
 *
 * The followings are the available columns in table 'publications_rating':
 * @property integer $id
 * @property integer $author_id
 * @property integer $post_id
 */
class PublicationsRating extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return PublicationsRating the static model class
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
		return 'publications_rating';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('author_id, post_id, type', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, author_id, post_id', 'safe', 'on'=>'search'),
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
			'author_id' => 'Author',
			'post_id' => 'Post',
			'type' => 'Type',
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
		$criteria->compare('author_id',$this->author_id);
		$criteria->compare('post_id',$this->post_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}