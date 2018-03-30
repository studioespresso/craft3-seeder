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
use verbb\supertable\fields\SuperTableField;

/**
 * Fields Service
 *
 * @author    Studio Espresso
 * @package   Seeder
 * @since     1.0.0
 */
class Supertable extends Component  {

	public $factory;

	public function __construct() {
		$this->factory = Factory::create();
	}

	/**
	 * @param SuperTableField $field
	 * @param $entry
	 *
	 * @return array|string
	 */
	public function SuperTableField($field, $entry) {
	}

}