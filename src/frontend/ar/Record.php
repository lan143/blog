<?php

namespace bulldozer\blog\frontend\ar;

use yii\helpers\Url;

/**
 * Class Record
 * @package bulldozer\blog\frontend\ar
 *
 * @property string $viewUrl
 * @property string $fullViewUrl
 *
 * @mixin \bulldozer\blog\common\ar\Record
 */
class Record extends \bulldozer\blog\common\ar\Record
{
    /**
     * @param bool $full
     * @return string
     */
    public function getViewUrl($full = false): string
    {
        return Url::to([
            '/blog/records/view',
            'slug' => $this->slug,
        ], $full);
    }

    /**
     * @return string
     */
    public function getFullViewUrl(): string
    {
        return $this->getViewUrl(true);
    }
}