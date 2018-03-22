<?php

namespace bulldozer\blog\frontend\controllers;

use bulldozer\App;
use bulldozer\blog\frontend\ar\Record;
use bulldozer\web\Controller;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

/**
 * Class RecordsController
 * @package bulldozer\blog\frontend\controllers
 */
class RecordsController extends Controller
{
    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex(): string
    {
        $query = Record::find()->orderBy(['created_at' => SORT_DESC]);

        /** @var Pagination $pagination */
        $pagination = App::createObject([
            'class' => Pagination::class,
            'defaultPageSize' => 10,
            'totalCount' => $query->count(),
            'forcePageParam' => false,
        ]);

        $query->offset($pagination->offset)
            ->limit($pagination->limit);

        $records = $query->all();

        return $this->render('index', [
            'records' => $records,
            'pagination' => $pagination,
        ]);
    }

    /**
     * @param string $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(string $slug): string
    {
        $record = Record::findOne(['slug' => $slug]);

        if ($record === null) {
            throw new NotFoundHttpException();
        }

        return $this->render('view', [
            'record' => $record,
        ]);
    }
}