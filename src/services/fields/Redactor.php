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

/**
 * Fields Service
 *
 * @author    Studio Espresso
 * @package   Seeder
 * @since     1.0.0
 */
class Redactor extends Component
{

    public $factory;

    public function __construct()
    {
        $this->factory = Factory::create();
    }

    public function Field($field, $entry)
    {
        return Lorem::sentences(rand(5, 20), true);
    }

}