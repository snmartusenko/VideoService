<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "image".
 *
 * @property integer $id
 * @property string $name
 * @property string $path
 * @property string $description
 * @property integer $status
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

            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name', 'path', 'description'], 'string', 'max' => 255],
            [['name'], 'unique', 'message' => 'This name already used'],
            [['path'], 'unique', 'message' => 'This path already used'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['ImageForUpload'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['name', 'path', 'status'], 'required'],
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

    // функция поиска активных записей
    public static function getActiveImageArray()
    {
        return Image::findAll(['status' => Image::STATUS_ACTIVE]);
    }

//    // функция поиска всех записей
//    public static function getAllImageArray()
//    {
//        return Image::find()->all();
//    }

    public static function getImageParentFolderPath()
    {
        return Yii::getAlias('@backend/web/');
    }

    public static function getImagesParentFolderLink()
    {
        return Yii::$app->request->hostInfo . '/backend/web/';
    }

    /**@param $file $ImageForUpload Сюда мы передадим обьект файла
     * @param $folder string Имя папки, в которую мы загрузим файл
     * @param null $id int Если нам нужно обновить картинку, а не загрузить новую, мы указываем ИД картинки в БД. По умолчанию null
     * @return Image|null */
    public static function uploadImageFile($file, $folder, $id = null)
    {
        // имя файла, не важно какое оно будет, главное чтобы не повторялось в приделе директории,
        // первой частью имени будет оригинальное имя, а второй - текущий timestamp.
        $imageName = $file->baseName . '_' . time();

        //берем полный путь папки в которую будем загружать картинки
        $path = self::getImageParentFolderPath();

        /** сохраняем картинку */
        $directory = $path . $folder;
        FileHelper::createDirectory($directory, 0777);
        $file->saveAs("$directory/$imageName." . $file->extension);
        if ($file) {
//            return true;
        } else {
            return false;
        }

        // добавить запись в таблицу Image
        if (!$id) {
            $modelImage = new Image();
        } else {
            $modelImage = Image::findOne($id);
            try {
                unlink($path . "/$modelImage->path");
            } catch (\Exception $exception) {
                //log
            }
        }

        $modelImage->name = $imageName;
        $modelImage->path = $folder . "/$imageName." . $file->extension;
        $modelImage->status = self::STATUS_ACTIVE;

        if ($modelImage->save()) {
            return $modelImage;
        }
        return null;
    }
}
