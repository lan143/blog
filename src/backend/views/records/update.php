<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var \bulldozer\blog\backend\forms\RecordForm $model
 * @var \bulldozer\blog\common\ar\Record $record
 */

$this->title = Yii::t('blog', 'Update blog record: {name}', ['name' => $record->name]);
$this->params['breadcrumbs'][] = $record->name;
$this->params['breadcrumbs'][] = Yii::t('blog', 'Update');
?>
<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                </div>

                <h2 class="panel-title"><?= Html::encode($this->title) ?></h2>
            </header>

            <div class="panel-body">
                <?= $this->render('_form', [
                    'model' => $model,
                    'isNew' => false,
                ]) ?>
            </div>
        </section>
    </div>
</div>
