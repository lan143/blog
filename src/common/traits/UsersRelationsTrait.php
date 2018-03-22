<?php

namespace bulldozer\blog\common\traits;

use bulldozer\db\ActiveRecord;
use bulldozer\users\models\User;
use yii\db\ActiveQuery;

/**
 * Trait UsersRelationsTrait
 * @package bulldozer\blog\common\traits
 *
 * @mixin ActiveRecord
 */
trait UsersRelationsTrait
{
    /**
     * @return ActiveQuery
     */
    public function getCreator() : ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'creator_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUpdater() : ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'updater_id']);
    }
}