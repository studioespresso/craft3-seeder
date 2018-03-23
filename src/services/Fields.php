<?php
/**
 * Seeder plugin for Craft CMS 3.x
 *
 * Entries seeder for Craft CMS
 *
 * @link      https://studioespresso.co
 * @copyright Copyright (c) 2018 Studio Espresso
 */

namespace studioespresso\seeder\services;

use Faker\Factory;
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
class Fields extends Component  {

	public $factory;

	public function __construct() {
		$this->factory = Factory::create();

	}

	public function PlainText($field) {
		return $this->factory->realText($field->charLimit ? $field->charLimit : 200);
	}

	public function Email($field) {
		return $this->factory->email();
	}

	public function Url($field) {
		return $this->factory->url();
	}
}