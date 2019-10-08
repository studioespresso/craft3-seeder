<?php

namespace studioespresso\seeder\records;

use craft\db\ActiveRecord;

class SeederCategoryRecord extends ActiveRecord
{

    // Props
    // =========================================================================

    public static $tableName = '{{%seeder_categories}}';

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
