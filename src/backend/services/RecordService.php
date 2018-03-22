<?php

namespace bulldozer\blog\backend\services;

use bulldozer\App;
use bulldozer\blog\backend\forms\RecordForm;
use bulldozer\blog\common\ar\Record;
use bulldozer\files\models\Image;
use yii\base\Exception;
use yii\web\UploadedFile;

/**
 * Class RecordService
 * @package bulldozer\blog\backend\services
 */
class RecordService
{
    /**
     * @param Record|null $record
     * @return RecordForm
     * @throws \yii\base\InvalidConfigException
     */
    public function getForm(?Record $record = null): RecordForm
    {
        /** @var RecordForm $form */
        $form = App::createObject([
            'class' => RecordForm::class,
        ]);

        if ($record) {
            $form->setAttributes($record->getAttributes($form->getSavedAttributes()));
        }

        return $form;
    }

    /**
     * @param RecordForm $form
     * @param Record|null $record
     * @return Record
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function save(RecordForm $form, ?Record $record = null): Record
    {
        $form->image = UploadedFile::getInstance($form, 'image');

        if ($record === null) {
            $record = App::createObject([
                'class' => Record::class,
            ]);
        }

        $transaction = App::$app->db->beginTransaction();

        $record->setAttributes($form->getAttributes($form->getSavedAttributes()));

        if ($record->save()) {
            if ($form->image) {
                if ($record->image) {
                    $record->image->delete();
                }

                $image = App::createObject([
                    'class' => Image::class,
                ]);

                if (!$image->upload($form->image) || !$image->save()) {
                    $transaction->rollback();

                    throw new Exception('Cant save image. Errors: ' . json_encode($image->getErrors()));
                }

                $record->image_id = $image->id;
                $record->save();
            }

            $transaction->commit();
            return $record;
        }

        $transaction->rollback();

        throw new Exception('Cant save record. Errors: ' . json_encode($record->getErrors()));
    }
}