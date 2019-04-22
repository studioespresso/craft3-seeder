<?php
/**
 * Seeder plugin for Craft CMS 3.x
 *
 * Entries seeder for Craft CMS
 *
 * @link      https://studioespresso.co
 * @copyright Copyright (c) 2018 Studio Espresso
 */

namespace studioespresso\seeder\services\fields;

use Faker\Factory;
use Faker\Provider\Base;
use Faker\Provider\Lorem;
use studioespresso\seeder\Seeder;

use Craft;
use craft\base\Component;
use verbb\supertable\elements\SuperTableBlockElement;
use verbb\supertable\fields\SuperTableField;

/**
 * Fields Service
 *
 * @author    Studio Espresso
 * @package   Seeder
 * @since     1.0.0
 */
class Supertable extends Component
{

    public $factory;

    public function __construct()
    {
        $this->factory = Factory::create();
    }

    public function SuperTableField(SuperTableField $field, $entry)
    {
        $types = $field->getBlockTypes();
        $fields = $field->getBlockTypeFields();

        if ($field->staticField) {
            $blockCount = 1;
        } else {
            $blockCount = rand(!empty($field->minRows) ? $field->minRows : 1, !empty($field->maxRows) ? $field->maxRows : 6);
        }

        $blockIds = [];

        $types = array_map(function ($type) {
            return $type->id;
        }, $types);

        for ($x = 1; $x <= $blockCount; $x++) {
            $blockIds[] = $types[array_rand($types, 1)];
        }

        foreach ($blockIds as $blockId) {
            $superTableBlock = new SuperTableBlockElement();
            $superTableBlock->typeId = $types[0];
            $superTableBlock->fieldId = $field->id;
            $superTableBlock->ownerId = $entry->id;
            $superTableBlock = Seeder::$plugin->seeder->populateFields($fields, $superTableBlock);
            Craft::$app->elements->saveElement($superTableBlock);

        }
        return;

    }

}