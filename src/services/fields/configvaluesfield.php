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
use rias\positionfieldtype\fields\Position;
use statikbe\configvaluesfield\fields\ConfigValuesFieldField;
use studioespresso\seeder\Seeder;

use Craft;
use craft\base\Component;

/**
 * Fields Service
 *
 * @author    Studio Espresso
 * @package   Seeder
 * @since     1.0.0
 */
class configvaluesfield extends Component
{

    public $factory;

    public function __construct()
    {
        $this->factory = Factory::create();
    }

    public function ConfigValuesFieldField(ConfigValuesFieldField $field, $entry)
    {
        if ($field->dataSet) {
            $options = \statikbe\configvaluesfield\ConfigValuesField::getInstance()->getSettings()->data[$field->dataSet];
            return array_rand($options);
        }
    }

}