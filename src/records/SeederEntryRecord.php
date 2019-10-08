<?php

namespace studioespresso\seeder\records;

use craft\db\ActiveRecord;

class SeederEntryRecord extends ActiveRecord
{

    // Props
    // =========================================================================

    public static $tableName = '{{%seeder_entries}}';

    /**
     * @inheritdoc
     *
     * @return string
     */
    public static function tableName(): string
    {
        return self::$tableName;
    }
}
