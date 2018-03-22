<?php

use bulldozer\blog\backend\widgets\SaveButtonsWidget;
use dosamigos\ckeditor\CKEditor;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var \bulldozer\blog\backend\forms\RecordForm $model
 * @var bool $isNew
 */

?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?php if ($model->hasErrors()): ?>
    <div class="alert alert-danger">
        <?= $form->errorSummary($model) ?>
    </div>
<?php endif ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'description')->textarea() ?>

<?= $form->field($model, 'body')->widget(CKEditor::class, [
    'options' => ['rows' => 12],
]) ?>

<?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']) ?>

<?= SaveButtonsWidget::widget(['isNew' => $isNew]) ?>

<?php ActiveForm::end(); ?>
