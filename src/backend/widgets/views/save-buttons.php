<?php
/**
 * @var bool $isNew
 */

use yii\helpers\Html;

?>
<div class="form-group" style="margin-top: 10px;">
    <?= Html::submitButton($isNew ? Yii::t('blog', 'Create') : Yii::t('blog', 'Update'),
        ['class' => $isNew ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?= Html::submitInput($isNew ? Yii::t('blog', 'Create and stay here') : Yii::t('blog', 'Update and stay here'),
        ['class' => $isNew ? 'btn btn-success' : 'btn btn-primary', 'name' => 'here-btn']) ?>
</div>