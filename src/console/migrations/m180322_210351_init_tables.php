<?php

namespace bulldozer\blog\console\migrations;

use bulldozer\App;
use bulldozer\users\rbac\DbManager;
use yii\base\InvalidConfigException;
use yii\db\Migration;

/**
 * Class m180322_210351_init_tables
 */
class m180322_210351_init_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%blog_records}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer(11)->unsigned(),
            'updated_at' => $this->integer(11)->unsigned(),
            'creator_id' => $this->integer(11)->unsigned(),
            'updater_id' => $this->integer(11)->unsigned(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'body' => $this->text(),
            'image_id' => $this->integer(11)->unsigned(),
            'slug' => $this->string(500)->notNull(),
        ], $tableOptions);

        $authManager = $this->getAuthManager();

        $manageBlog = $authManager->createPermission('blog_manage');
        $manageBlog->name = 'Управление блогом';
        $authManager->add($manageBlog);

        $admin = $authManager->getRole('admin');
        $authManager->addChild($admin, $manageBlog);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%blog_records}}');

        $authManager = $this->getAuthManager();

        $manageBlog = $authManager->getPermission('blog_manage');
        $authManager->remove($manageBlog);
    }

    /**
     * @throws InvalidConfigException
     * @return DbManager
     */
    protected function getAuthManager()
    {
        $authManager = App::$app->getAuthManager();

        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }

        return $authManager;
    }
}
