<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Subscription".
 *
 * @property integer $user_id
 * @property integer $section_id
 */
class Subscription extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Subscription';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['user_id', 'section_id'], 'integer'],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::className(), 'targetAttribute' => ['section_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['user_id', 'section_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'section_id' => 'Section ID',
        ];
    }
}
