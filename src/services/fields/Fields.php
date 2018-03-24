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

use craft\fields\Email;
use craft\fields\Matrix;
use craft\fields\PlainText;
use craft\fields\Url;
use craft\models\MatrixBlockType;
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
class Fields extends Component  {

	public $factory;

	public function __construct() {
		$this->factory = Factory::create();

	}

	public function Title() {
		$title = $this->factory->realText(rand(15, 40));
		$title = substr($title, 0, strlen($title) - 1);
		return $title;
	}

	/**
	 * @param PlainText $field
	 */
	public function PlainText($field) {
		return $this->factory->realText($field->charLimit ? $field->charLimit : 200);
	}

	/**
	 * @param Email $field
	 */
	public function Email($field) {
		return $this->factory->email();
	}

	/**
	 * @param Url $field
	 **/
	public function Url($field) {
		return $this->factory->url();
	}

	/**
	 * @param Matrix $field
	 */
	public function Matrix($field) {
		/* @var $blockType MatrixBlockType*/
		foreach($field->getBlockTypes() as $blockType) {
			$blockTypeLayout = $blockType->fieldLayoutId;

		}
	}
}