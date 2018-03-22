<?php

namespace bulldozer\blog\backend\controllers;

use bulldozer\App;
use bulldozer\blog\backend\services\RecordService;
use bulldozer\blog\common\ar\Record;
use bulldozer\web\Controller;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * Class RecordsController
 * @package bulldozer\blog\backend\controllers
 */
class RecordsController extends Controller
{
    /**
     * @var RecordService
     */
    private $recordService;

    /**
     * RecordsController constructor.
     * @param string $id
     * @param $module
     * @param RecordService $recordService
     * @param array $config
     */
    public function __construct(string $id, $module, RecordService $recordService, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->recordService = $recordService;
    }

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['blog_manage'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Record models.
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        $dataProvider = App::createObject([
            'class' => ActiveDataProvider::class,
            'query' => Record::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Record model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionCreate()
    {
        $model = $this->recordService->getForm();

        if ($model->load(App::$app->request->post()) && $model->validate()) {
            $banner = $this->recordService->save($model);
            App::$app->getSession()->setFlash('success', Yii::t('blog', 'Blog record successful created'));

            if (!App::$app->request->post('here-btn')) {
                return $this->redirect(['index']);
            } else {
                return $this->redirect(['update', 'id' => $banner->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Record model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionUpdate(int $id)
    {
        $record = $this->findModel($id);

        $model = $this->recordService->getForm($record);

        if ($model->load(App::$app->request->post()) && $model->validate()) {
            $this->recordService->save($model, $record);
            App::$app->getSession()->setFlash('success', Yii::t('blog', 'Blog record successful updated'));

            if (!App::$app->request->post('here-btn')) {
                return $this->redirect(['index']);
            } else {
                return $this->redirect(['update', 'id' => $record->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'record' => $record,
        ]);
    }

    /**
     * Deletes an existing Record model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->getSession()->setFlash('success', Yii::t('blog', 'Blog record successful deleted'));

        return $this->redirect(['index']);
    }

    /**
     * Finds the Record model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Record the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Record
    {
        if (($model = Record::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}