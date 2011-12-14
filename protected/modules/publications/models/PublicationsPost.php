<?php

/**
 * This is the model class for table "publications_posts".
 *
 * The followings are the available columns in table 'publications_posts':
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $content
 * @property string $tags
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $category_id
 * @property integer $author_id
 */
class PublicationsPost extends CActiveRecord
{
    public $image;
    public $main_image;
    public $post_date;
    
    const STATUS_DRAFT=1;
	const STATUS_PUBLISHED=2;
	const STATUS_ARCHIVED=3;

	private $_oldTags;
    
    public function scopes()
    {
        return array(
            'featured' => array(
                'condition'=>'t.status='.self::STATUS_PUBLISHED.' and t.show_on_main = 1',
                'order'=>'t.post_date DESC',
                'limit'=>10,
                'with' => array('category')
            )
        );
    }
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return PublicationsPost the static model class
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
		return 'publications_posts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('title, alias, content, status, category_id, post_date', 'required'),
            array('category_id, author_id, rating', 'numerical', 'integerOnly'=>true),
			array('status', 'in', 'range'=>array(1,2,3)),
			array('title', 'length', 'max'=>128),
			array('alias', 'unique', 'allowEmpty' => false, 'caseSensitive' => true),
			//array('tags', 'match', 'pattern'=>'/^[\w\s,]+$/', 'message'=>'Tags can only contain word characters.'),
			array('tags', 'normalizeTags'),
			array('title, status, show_on_main, alias', 'safe'),
            array('image, main_image', 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty' => true),
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
			'author' => array(self::BELONGS_TO, 'User', 'author_id'),
			'category' => array(self::BELONGS_TO, 'PublicationsCategory', 'category_id'),
			'comments' => array(self::HAS_MANY, 'PublicationsComment', 'post_id', 'condition'=>'comments.status='.PublicationsComment::STATUS_APPROVED, 'with' => array('author'), 'order'=>'comments.root ASC, comments.lft ASC, comments.create_time ASC'),
			'ratingCheck' => array(self::HAS_MANY, 'PublicationsRating', 'post_id', 'condition'=> !Yii::app()->user->isGuest ? 'ratingCheck.author_id = '.intval(Yii::app()->user->id) : ''),
			'commentCount' => array(self::STAT, 'PublicationsComment', 'post_id', 'condition'=>'status='.PublicationsComment::STATUS_APPROVED),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Заголовок',
			'alias' => 'Постоянная ссылка',
			'content' => 'Текст',
			'tags' => 'Тэги',
			'status' => 'Статус',
			'create_time' => 'Дата создания',
			'update_time' => 'Дата обновления',
			'category_id' => 'Категория',
			'author_id' => 'Автор',
            'post_date' => 'Дата публикации',
            'image' => 'Изображение (бейджик)',
            'main_image' => 'Изображение (на главной)',
            'show_on_main' => 'Отображать на главной',
            'rating' => 'Рейтинг'
		);
	}

	/**
	 * @return string the URL that shows the detail of the post
	 */
	public function getUrl($bPublic = false)
	{
        if (Yii::app() instanceof CmsApplication || $bPublic) {
            return '/wave/'.$this->category->alias.'/'.$this->alias;
        } else {
            return false;
        }
        
		/*return Yii::app()->createUrl('/publications/publicationsPost/view', array(
			'id'=>$this->id,
			//'title'=>$this->title,
		));*/
	}

	/**
	 * @return array a list of links that point to the post list filtered by every tag of this post
	 */
	public function getTagLinks()
	{
		$links=array();
		foreach(PublicationsTag::string2array($this->tags) as $tag)
			$links[]= CHtml::link(CHtml::encode($tag), '/wave/tag/'.$tag);
		return $links;
	}

	/**
	 * Normalizes the user-entered tags.
	 */
	public function normalizeTags($attribute,$params)
	{
		$this->tags=PublicationsTag::array2string(array_unique(PublicationsTag::string2array($this->tags)));
	}

	/**
	 * Adds a new comment to this post.
	 * This method will set status and post_id of the comment accordingly.
	 * @param Comment the comment to be added
	 * @return boolean whether the comment is saved successfully
	 */
	public function addComment($comment, $nParentId)
	{
        
        
        
		if(Yii::app()->getModule('publications')->commentNeedApproval)
			$comment->status=PublicationsComment::STATUS_PENDING;
		else
			$comment->status=PublicationsComment::STATUS_APPROVED;
		$comment->post_id=$this->id;
        $comment->author_id = Yii::app()->user->id;
        
        if ($nParentId) {
            $parent = PublicationsComment::model()->findByPk($nParentId);
            $comment->appendTo($parent);
        }
        
        
		return $comment->saveNode();
	}

	/**
	 * This is invoked when a record is populated with data from a find() call.
	 */
	protected function afterFind()
	{
		parent::afterFind();
		$this->_oldTags=$this->tags;
        
        $this->post_date = date("d.m.Y H:i:s", strtotime($this->post_date));
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
			{
				$this->create_time=$this->update_time=time();
				$this->author_id=Yii::app()->user->id;
			}
			else {
                $this->post_date = date("Y-m-d H:i:s", strtotime($this->post_date));
				$this->update_time=time();
            }
			return true;
		}
		else
			return false;
	}

	/**
	 * This is invoked after the record is saved.
	 */
	protected function afterSave()
	{
		parent::afterSave();
		PublicationsTag::model()->updateFrequency($this->_oldTags, $this->tags);
        $this->post_date = date("d.m.Y H:i:s", strtotime($this->post_date));
	}

	/**
	 * This is invoked after the record is deleted.
	 */
	protected function afterDelete()
	{
		parent::afterDelete();
		Comment::model()->deleteAll('post_id='.$this->id);
		PublicationsTag::model()->updateFrequency($this->tags, '');
	}

	/**
	 * Retrieves the list of posts based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the needed posts.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('title',$this->title,true);

		$criteria->compare('status',$this->status);
		$criteria->compare('category_id',$this->category_id);

		return new CActiveDataProvider('PublicationsPost', array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'status, post_date DESC',
			),
		));
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
    
    public function findBestPosts($limit = 10)
	{
		return $this->findAll(array(
			'condition'=>'t.status='.self::STATUS_PUBLISHED,
			'order'=>'t.rating DESC, t.post_date DESC',
			'limit'=>$limit,
            'with' => array('category')
		));
	}
    
    public function getPreviousPost()
    {
        return $this->find(array(
			'condition'=>'t.status='.self::STATUS_PUBLISHED.' AND t.post_date <= \''.date("Y-m-d H:i:s", strtotime($this->post_date)).'\' AND t.id <> '.$this->id,
			'order'=>'t.post_date DESC',
            'with' => array('category')
		));
    }
    
    public function getNextPost()
    {
        return $this->find(array(
			'condition'=>'t.status='.self::STATUS_PUBLISHED.' AND t.post_date >= \''.date("Y-m-d H:i:s", strtotime($this->post_date)).'\' AND t.id <> '.$this->id,
			'order'=>'t.post_date DESC',
            'with' => array('category')
		));
    }
    
    public function searchPostsCount($sQuery, $limit = 10, $offset = 0)
    {
        $criteria=new CDbCriteria;
        $criteria->condition="t.status=:status AND (t.title LIKE '%".$sQuery."%' OR t.content LIKE '%".$sQuery."%' OR category.title LIKE '%".$sQuery."%')";
        $criteria->params=array(':status' => self::STATUS_PUBLISHED);
        $criteria->with = array('category');
        return $this->count($criteria);
    }
}