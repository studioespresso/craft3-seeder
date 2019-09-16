<?php

namespace studioespresso\seeder\records;

use craft\db\ActiveRecord;

class SeederAssetRecord extends ActiveRecord
{

    // Props
    // =========================================================================

    public static $tableName = '{{%seeder_assets}}';

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
