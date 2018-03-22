<?php

namespace bulldozer\blog\backend;

use bulldozer\App;
use bulldozer\base\BackendModule;
use Yii;
use yii\i18n\PhpMessageSource;

/**
 * Class Module
 * @package bulldozer\blog\backend
 */
class Module extends BackendModule
{
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

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     */
    public function createController($route)
    {
        $validRoutes = ['records'];
        $isValidRoute = false;

        foreach ($validRoutes as $validRoute) {
            if (strpos($route, $validRoute) === 0) {
                $isValidRoute = true;
                break;
            }
        }

        return (empty($route) or $isValidRoute)
            ? parent::createController($route)
            : parent::createController("{$this->defaultRoute}/{$route}");
    }

    /*
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $action->controller->view->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'Blog'), 'url' => ['/blog']];

        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function getMenuItems(): array
    {
        $moduleId = isset(App::$app->controller->module) ? App::$app->controller->module->id : '';

        return [
            [
                'label' => Yii::t('blog', 'Blog'),
                'icon' => 'fa fa-rss',
                'url' => ['/blog'],
                'rules' => ['blog_manage'],
                'active' => $moduleId == 'blog',
            ],
        ];
    }
}