<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "video".
 *
 * @property integer $id
 * @property string $name
 * @property string $path
 * @property string $description
 * @property integer $status
 * @property integer $topic_id
 * @property integer $preview_image
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Like[] $likes
 * @property Image $previewImage
 * @property Topic $topic
 */
class Video extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 10;
    const STATUS_INV = 5;
    const STATUS_DELETED = 0;

    public $VideoForUpload;

    public $ImageForUpload;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%video}}';
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
            [['status', 'topic_id', 'preview_image', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name', 'path', 'description'], 'string', 'max' => 255],
            [['name'], 'unique', 'message' => 'This name already used'],
            [['path'], 'unique', 'message' => 'This path already used'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['preview_image'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['preview_image' => 'id']],
            [['topic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Topic::className(), 'targetAttribute' => ['topic_id' => 'id']],
            [['VideoForUpload'], 'file', 'skipOnEmpty' => true, 'extensions' => 'mp4, flv'],
            [['ImageForUpload'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['name', 'path', 'status', 'topic_id', 'preview_image'], 'required'],
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
            'topic_id' => 'Topic ID',
            'preview_image' => 'Preview Image',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLikes()
    {
        return $this->hasMany(Like::className(), ['video_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreviewImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'preview_image']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'topic_id']);
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

    public function getDate($date)
    {
        return Yii::$app->formatter->asDate($date, 'medium');
    }

    // найти все активные видео
    public static function getActiveVideoArray()
    {
        return Video::findAll(['status' => Video::STATUS_ACTIVE]);
    }

    // найти активные видео в топике
    public static function getActiveVideosInTopic($id)
    {
        return Video::find()
            ->where(['status' => Video::STATUS_ACTIVE])
            ->andWhere(['topic_id' => $id])
            ->orderBy('id')
            ->all();
    }

    public static function getVideoParentFolderPath()
    {
        return Yii::getAlias('@backend/web/');
    }

    public static function getVideoParentFolderLink()
    {
        return Yii::$app->request->hostInfo . '/backend/web/';
    }

    // ���������� ����� ��� ������ ����� ������ ��� ��������� � ������� ��� � ������ (��� ������ ������ ��������� ������)
    public function __toString()
    {
        return (string)$this->name;
    }

    // Upload the image
    public function uploadImage($id = null)
    {
        $file = UploadedFile::getInstance($this, 'ImageForUpload');

        if ($file !== null) {
            $ImageModel = Image::uploadImageFile($file, "media/images/preview", $id);
            return $ImageModel;
        }

        return null;
    }

    // Upload the video
    public function uploadVideo($id = null)
    {
        $file = UploadedFile::getInstance($this, 'VideoForUpload');

        if ($file !== null) {
            $folder = 'media/videos';
            $videoName = self::uploadVideoFile($file, $folder, $id);

            if ($videoName != null) {
                $this->path = $folder . "/$videoName" . '.' . $file->extension;
                $this->status = self::STATUS_ACTIVE;
                return true;
            }
        }

        return false;
    }

    /**@param $file $ImageForUpload ���� �� ��������� ������ �����
     * @param $folder string ��� �����, � ������� �� �������� ����
     * @param null $id int ���� ��� ����� �������� ��������, � �� ��������� �����, �� ��������� �� �������� � ��. �� ��������� null
     * @return Image|null */
    public static function uploadVideoFile($file, $folder, $id = null)
    {
        // ��� �����, �� ����� ����� ��� �����, ������� ����� �� ����������� � ������� ����������,
        // ������ ������ ����� ����� ������������ ���, � ������ - ������� timestamp.
        $videoName = $file->baseName . '_' . time();

        //����� ������ ���� ����� � ������� ����� ��������� ��������
        $path = self::getVideoParentFolderPath();

        /** ��������� �������� */
        $directory = $path . $folder;
        FileHelper::createDirectory($directory, 0777);
        $file->saveAs("$directory/$videoName." . $file->extension);
        if ($file) {
            return $videoName;
        } else {
            return null;
        }

    }

    public function DeactivateVideo()
    {
        return $this->status = self::STATUS_DELETED;
    }
}
