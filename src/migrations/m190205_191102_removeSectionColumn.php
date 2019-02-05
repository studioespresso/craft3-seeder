<?php

namespace studioespresso\seeder\migrations;

use Craft;
use craft\db\Migration;
use studioespresso\seeder\records\SeederCategoryRecord;

/**
 * m190205_191102_removeSectionColumn migration.
 */
class m190205_191102_removeSectionColumn extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropColumn(SeederCategoryRecord::tableName(), 'section');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m190205_191102_removeSectionColumn cannot be reverted.\n";
        return false;
    }
}
