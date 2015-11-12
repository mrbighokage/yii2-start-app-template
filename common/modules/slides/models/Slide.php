<?php

namespace common\modules\slides\models;

use common\helpers\ThumbHelper;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Slide model
 *
 * @property integer $id
 * @property integer $status
 * @property integer $type
 * @property integer $order
 * @property string $url
 * @property string $title
 * @property string $comment
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class Slide extends ActiveRecord
{

    /**
     * @var UploadedFile
     */
    public  $imageFile;
    private $dirName = 'slides';

    const STATUS_DISABLE = 0;
    const STATUS_ENABLE = 1;

    const TYPE_MAIN = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%slides}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'title'], 'required'],
            ['url', 'url', 'defaultScheme' => 'http'],

            ['status', 'default', 'value' => self::STATUS_ENABLE],
            ['status', 'in', 'range' => array_keys(self::getStatusList())],

            ['type', 'default', 'value' => self::TYPE_MAIN],
            ['type', 'in', 'range' => array_keys(self::getTypeList())],

            ['order',  'integer'],

            ['title', 'string', 'min' => 5, 'max' => 255],
            ['image', 'string', 'max' => 255],
            ['comment', 'string', 'min' => 0, 'max' => 1024],

            [['imageFile'],
                'image', 'skipOnEmpty' => false,
                'extensions' => 'png, jpg',
                'maxWidth' => 1920,
                'maxHeight' => 400,
                'on' => ['upload']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'upload' => [
                'imageFile'
            ],
            'default' => [
                'url',
                'status',
                'type',
                'order',
                'title',
                'image',
                'comment'
            ]
        ];
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {

            if($this->image) {
                $this->removeImage();
            }
            return true;
        } else {
            return false;
        }
    }

    public function removeImage() {
        if($this->image) {
            $file = Yii::getAlias('@uploads/' . $this->dirName) . '/' . $this->image;
            if (file_exists($file)) {
                unlink($file);
                ThumbHelper::removeThumbs($this->getImg());
            }
        }
    }

    public static function getStatusList() {
        return [
            self::STATUS_DISABLE => Yii::t('app', 'Неактивный'),
            self::STATUS_ENABLE => Yii::t('app', 'Активный')
        ];
    }

    public static function getTypeList() {
        return [
            self::TYPE_MAIN => Yii::t('app', 'Главный слайдер'),
        ];
    }

    public function upload()
    {
        $this->setScenario('upload');
        if($this->validate()) {
            $patch = Yii::getAlias('@uploads/' . $this->dirName);
            if (!is_dir($patch)) {
                mkdir($patch);
            }

            $fileName = 'sl_' . Yii::$app->security->generateRandomString(8) . '.' . $this->imageFile->extension;
            if($this->imageFile->saveAs($patch . '/' . $fileName)) {
                $this->removeImage();
            }
            $this->image = $fileName;
            return true;
        }
        return false;
    }

    public function getImg() {
        if($this->image) {
            return Yii::getAlias('/uploads/' . $this->dirName . '/' . $this->image);
        }
        return false;
    }

    public static function getActiveSlides() {
        return Slide::find()
            ->select(['image', 'url', 'title'])
            ->where('status = :status', [
                ':status' => Slide::STATUS_ENABLE
            ])
            ->all();
    }

}
