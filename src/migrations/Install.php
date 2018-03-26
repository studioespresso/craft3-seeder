<?php

namespace studioespresso\seeder\migrations;

use Craft;
use craft\db\Migration;
use studioespresso\seeder\records\SeederAssetRecord;
use studioespresso\seeder\records\SeederEntryRecord;
use yii\db\Schema;

/**
 * Install migration.
 */
class Install extends Migration
{
	/**
	 * @inheritdoc
	 */
	public function safeUp()
	{

		$this->createTable(
			SeederEntryRecord::$tableName, [
			'id' => $this->primaryKey(),
			'entryId' => $this->integer()->notNull(),
			'section' => $this->integer()->notNull(),

			'dateCreated' => $this->dateTime()->notNull(),
			'dateUpdated' => $this->dateTime()->notNull(),
			'uid'         => $this->uid()->notNull(),
		] );

		$this->createTable(
			SeederAssetRecord::$tableName, [
			'id' => $this->primaryKey(),
			'assetId' => $this->integer()->notNull(),

			'dateCreated' => $this->dateTime()->notNull(),
			'dateUpdated' => $this->dateTime()->notNull(),
			'uid'         => $this->uid()->notNull(),
		] );

	}

	/**
	 * @inheritdoc
	 */
	public function safeDown()
	{
		$this->dropTable(SeederEntryRecord::$tableName);
		$this->dropTable(SeederAssetRecord::$tableName);
	}
}
