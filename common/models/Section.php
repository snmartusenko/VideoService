<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "section".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property integer $status
 * @property integer $image_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Image $image
 * @property Subscription[] $subscriptions
 * @property User[] $users
 * @property Topic[] $topics
 */



class Section extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 10;
    const STATUS_INV = 5;
    const STATUS_DELETED = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%section}}';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at']
                ],
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by'
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug', /*'image_id'*/], 'required'],
            [['status', 'image_id', /*'created_at', 'created_by', 'updated_at', 'updated_by'*/], 'integer'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['slug'], 'unique'],
            ['image_id', 'default', 'value' => 1],
            ['status', 'default', 'value' => STATUS_ACTIVE],
            //[['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'status' => 'Status',
            'image_id' => 'Image ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriptions()
    {
        return $this->hasMany(Subscription::className(), ['section_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('subscription', ['section_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopics()
    {
        return $this->hasMany(Topic::className(), ['section_id' => 'id']);
    }

    public function getCreatedBy($attribute){
        /** @var User $user */
        $user = User::findOne($this->created_by);

        return $user->hasAttribute($attribute) ? $user->{$attribute} : $user->email;
    }

    public function getUpdatedBy($attribute){
        /** @var User $user */
        $user = User::findOne($this->updated);

        return $user->hasAttribute($attribute) ? $user->{$attribute} : $user->email;
    }

    public function getDate($date){
        return Yii::$app->formatter->asDate($date, 'medium');
    }

    //функция поиска активных секций
    public static function getActiveSectionArray()
    {
        return Section::findAll(['status' => Section::STATUS_ACTIVE]);
    }
}
