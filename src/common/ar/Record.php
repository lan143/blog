<?php

namespace bulldozer\blog\common\ar;

use bulldozer\blog\common\traits\UsersRelationsTrait;
use bulldozer\db\ActiveRecord;
use bulldozer\files\models\Image;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * Class Record
 * @package bulldozer\blog\common\ar
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $creator_id
 * @property integer $updater_id
 * @property string $name
 * @property string $description
 * @property string $body
 * @property integer $image_id
 * @property string $slug
 *
 * @property-read Image $image
 */
class Record extends ActiveRecord
{
    use UsersRelationsTrait;

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'creator_id',
                'updatedByAttribute' => 'updater_id',
            ],
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'ensureUnique' => true,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%blog_records}}';
    }

    public function getImage(): ActiveQuery
    {
        return $this->hasOne(Image::class, ['id' => 'image_id']);
    }
}