<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "image".
 *
 * @property integer $id
 * @property string $name
 * @property string $path
 * @property string $description
 * @property integer $status
 * @property integer $section_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Section[] $sections
 * @property Video[] $videos
 */
class Image extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 10;
    const STATUS_INV = 5;
    const STATUS_DELETED = 0;

    public $ImageForUpload;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%image}}';
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

            [['status', 'section_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name', 'path', 'description'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['path'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['ImageForUpload'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['name', 'path', 'section_id'], 'required'],
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
            'path' => 'Path',
            'description' => 'Description',
            'status' => 'Status',
            'section_id' => 'Section ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSections()
    {
        return $this->hasMany(Section::className(), ['image_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideos()
    {
        return $this->hasMany(Video::className(), ['preview_image' => 'id']);
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

    // ������� ������ �������� �������
    public static function getActiveImageArray()
    {
        return Image::findAll(['status' => Image::STATUS_ACTIVE]);
    }

    // ������� ������ ���� �������
    public static function getAllImageArray()
    {
        return Image::find()->all();
    }

    // �������� � ����������
    public function upload()
    {
        if ($this->validate()) {

            $this->ImageForUpload->saveAs($this->path, $deleteTempFile = false);
            return true;
        } else {
            return false;
        }
    }
}
