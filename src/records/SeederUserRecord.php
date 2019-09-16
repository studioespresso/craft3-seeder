<?php

namespace studioespresso\seeder\records;

use craft\db\ActiveRecord;

class SeederUserRecord extends ActiveRecord
{

    // Props
    // =========================================================================

    public static $tableName = '{{%seeder_user}}';

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
