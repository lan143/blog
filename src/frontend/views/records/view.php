<?php
/**
 * @var \bulldozer\blog\frontend\ar\Record $record
 */

$this->title = $record->name;
$this->params['breadcrumbs'][] = ['label' => $record->name];
?>
<h1><?= $record->name ?></h1>

<div class="row">
    <div class="col-md-12">
        <?= $record->body ?>
    </div>
</div>
