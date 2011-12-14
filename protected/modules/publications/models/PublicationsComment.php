<?php

/**
 * This is the model class for table "publications_comments".
 *
 * The followings are the available columns in table 'publications_comments':
 * @property integer $id
 * @property string $content
 * @property integer $status
 * @property integer $create_time
 * @property string $author_id
 * @property integer $post_id
 */
class PublicationsComment extends CActiveRecord
{
    const STATUS_PENDING=1;
	const STATUS_APPROVED=2;
    
    public $parentId;
    
    public function behaviors()
    {
        return array(
            'tree'=>array(
                'class'=>'ext.yiiext.behaviors.model.trees.NestedSetBehavior',
                'leftAttribute'=>'lft',
                'rightAttribute'=>'rgt',
                'levelAttribute'=>'level',
                'rootAttribute' => 'root',
                'hasManyRoots' => true
            )
        );
    }
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return PublicationsComment the static model class
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
		return 'publications_comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content', 'required'),
            array('rating', 'numerical', 'integerOnly'=>true),
            array('content','filter','filter' => array($obj = new CHtmlPurifier(), 'purify')),
			//array('author_id','safe'),
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
			'post' => array(self::BELONGS_TO, 'PublicationsPost', 'post_id'),
			'author' => array(self::BELONGS_TO, 'User', 'author_id', 'with' => array('profile')),
            'ratingCheck' => array(self::HAS_MANY, 'PublicationsCommentsRating', 'comment_id', 'condition'=> !Yii::app()->user->isGuest ? 'ratingCheck.author_id = '.intval(Yii::app()->user->id) : ''),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'content' => 'Комментарий',
			'status' => 'Статус',
			'create_time' => 'Дата создания',
			'author_id' => 'Автор',
			'post_id' => 'Публикация',
		);
	}

	/**
	 * Approves a comment.
	 */
	public function approve()
	{
		$this->status=PublicationsComment::STATUS_APPROVED;
		$this->update(array('status'));
	}

	/**
	 * @param Post the post that this comment belongs to. If null, the method
	 * will query for the post.
	 * @return string the permalink URL for this comment
	 */
	public function getUrl($post=null)
	{
		if($post===null)
			$post=$this->post;
		return $post->url.'#c'.$this->id;
	}

	/**
	 * @return string the hyperlink display for the current comment's author
	 */
	public function getAuthorLink()
	{
        return CHtml::encode($this->author->username);
	}

	/**
	 * @return integer the number of comments that are pending approval
	 */
	public function getPendingCommentCount()
	{
		return $this->count('status='.self::STATUS_PENDING);
	}

	/**
	 * @param integer the maximum number of comments that should be returned
	 * @return array the most recently added comments
	 */
	public function findRecentComments($limit=10)
	{
		return $this->with('post')->findAll(array(
			'condition'=>'t.status='.self::STATUS_APPROVED,
			'order'=>'t.create_time DESC',
			'limit'=>$limit,
		));
	}

	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
				$this->create_time=time();
			return true;
		}
		else
			return false;
	}
    
    public function checkUserRating()
    {
        if ($this->id && !Yii::app()->user->isGuest) {
            
            if ($this->author_id == Yii::app()->user->id) {
                return false;
            } else {            
                return count($this->ratingCheck) ? false : true;
            }
        }
        
        return false;
    }
}