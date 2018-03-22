<?php
/**
 * @var \bulldozer\blog\frontend\ar\Record[] $records
 * @var \yii\data\Pagination $pagination
 */

use yii\widgets\LinkPager;

?>
<div class="row">
    <?php foreach ($records as $record): ?>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <?php if ($record->image): ?>
                        <img src="<?= $record->image->getWebFilePath() ?>" class="img-responsive" alt="<?= $record->name ?>">
                    <?php endif ?>
                </div>

                <div class="col-md-8">
                    <a href="<?= $record->viewUrl ?>">
                        <h2><?= $record->name ?></h2>
                    </a>

                    <?= $record->description ?>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>

<div style="text-align: center;">
    <?= LinkPager::widget(['pagination' => $pagination]) ?>
</div>
