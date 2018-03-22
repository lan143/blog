<?php

namespace bulldozer\blog\backend\forms;

use bulldozer\base\Form;
use Yii;
use yii\web\UploadedFile;

/**
 * Class RecordForm
 * @package bulldozer\blog\backend\forms
 */
class RecordForm extends Form
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $body;

    /**
     * @var UploadedFile
     */
    public $image;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 255],

            ['description', 'string'],

            ['body', 'required'],
            ['body', 'string'],

            ['image', 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'name' => Yii::t('blog', 'Name'),
            'description' => Yii::t('blog', 'Description'),
            'body' => Yii::t('blog', 'Body'),
            'image' => Yii::t('blog', 'Image'),
        ];
    }

    /**
     * @return array
     */
    public function getSavedAttributes(): array
    {
        return [
            'name',
            'description',
            'body',
        ];
    }
}