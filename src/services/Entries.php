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

use craft\elements\Entry;
use craft\errors\FieldNotFoundException;
use Faker\Factory;
use Faker\Provider\Person;
use studioespresso\seeder\Seeder;

use Craft;
use craft\base\Component;
use yii\base\Model;

/**
 * SeederService Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Studio Espresso
 * @package   Seeder
 * @since     1.0.0
 */
class Entries extends Component
{
	/**
	 * @param null $sectionId
	 *
	 * @throws \Throwable
	 * @throws \craft\errors\ElementNotFoundException
	 * @throws \yii\base\Exception
	 * @throws \yii\base\InvalidConfigException
	 */
	public function generate($sectionId = null) {
		$faker = Factory::create();

		$section = Craft::$app->sections->getSectionById((int)$sectionId);
		foreach($section->getEntryTypes() as $entryType) {
			$typeFields = Craft::$app->fields->getFieldsByLayoutId($entryType->getFieldLayoutId());
			$entry = new Entry([
				'sectionId' => (int)$sectionId,
				'typeId' => $entryType->id,
				'title' => $faker->realText(30),
			]);
			$entry = $this->populateFields($typeFields, $entry);
			Craft::$app->getElements()->saveElement($entry);
		}
	}

	/**
	 * @param $fields
	 * @param Entry $entry
	 */
	private function populateFields($fields, $entry) {
		$entryFields = [];
		foreach($fields as $field) {
			try {
				$fieldType = $this->isFieldSupported($field);
				if($fieldType) {
					$entryFields[$field['handle']] = Seeder::$plugin->fields->$fieldType($field);
				}

			} catch (FieldNotFoundException $e) {

			}
		}
		$entry->setFieldValues($entryFields);
		return $entry;

	}

	private function isFieldSupported($field) {
		$fieldType = explode('\\', get_class($field));
		$fieldType = end($fieldType);
		if(in_array($fieldType, get_class_methods(Seeder::$plugin->fields))) {
			return $fieldType;
		} else {
			throw new FieldNotFoundException('Fieldtype not supported');
		}
	}

}
