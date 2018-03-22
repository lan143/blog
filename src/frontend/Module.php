<?php

namespace bulldozer\blog\frontend;

use bulldozer\App;
use bulldozer\base\FrontendModule;
use Yii;
use yii\i18n\PhpMessageSource;

/**
 * Class Module
 * @package bulldozer\blog\frontend
 */
class Module extends FrontendModule
{
    /**
     * @var string
     */
    public $defaultRoute = 'records';

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();

        if (empty(App::$app->i18n->translations['blog'])) {
            App::$app->i18n->translations['blog'] = [
                'class' => PhpMessageSource::class,
                'basePath' => __DIR__ . '/../messages',
            ];
        }
    }

    /*
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $action->controller->view->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'Blog'), 'url' => ['/blog']];

        return parent::beforeAction($action);
    }
}