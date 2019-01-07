<?php

use yii\db\Schema;
use yii\db\Migration;

class m130524_201442_muayene extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%muayenes}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(200)->notNull(),
			'description' => $this->text()->notNull(),
            'picture' => $this->text(),
        ], $tableOptions);

        $this->createTable('{{%muayene_data}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'muayene_id' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->createIndex(
            'idx_muayene_data_muayene_id-1',
            'muayene_data',
            'muayene_id'
        );

        $this->addForeignKey(
          'fk_muayene_data_muayene_id-1',
          'muayene_data',
          'muayene_id',
          'muayenes',
          'id'
        );

    }

    public function down()
    {
        $this->dropForeignKey('fk_muayene_data_muayene_id-1','muayene_data');
        $this->dropIndex('idx_muayene_data_muayene_id-1','muayene_data');
        $this->dropTable('{{%muayene_data}}');
        $this->dropTable('{{%muayenes}}');
    }
}
