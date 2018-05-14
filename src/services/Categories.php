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

use craft\elements\Asset;
use craft\elements\Category;
use craft\elements\Entry;
use craft\errors\FieldNotFoundException;
use Faker\Factory;
use Faker\Provider\Person;
use studioespresso\seeder\records\SeederAssetRecord;
use studioespresso\seeder\records\SeederCategoryRecord;
use studioespresso\seeder\records\SeederEntryRecord;
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
class Categories extends Component {
	/**
	 * @param null $sectionId
	 *
	 * @throws \Throwable
	 * @throws \craft\errors\ElementNotFoundException
	 * @throws \yii\base\Exception
	 * @throws \yii\base\InvalidConfigException
	 */
	public function generate( $groupId = null, $count ) {
		$faker = Factory::create();
		$categoryGroup = Craft::$app->categories->getGroupById((int) $groupId);

		
		for ( $x = 1; $x <= $count; $x ++ ) {
			$category      = new Category( [
				'groupId' => (int) $groupId,
				'title'     => Seeder::$plugin->fields->Title(20),
			] );

			Craft::$app->getElements()->saveElement( $category );
			$this->saveSeededCategory($category);
		}

	}

    /**
     * @param Asset $asset
     */
    public function saveSeededCategory($category) {
        $record = new SeederCategoryRecord();
        $record->categoryUid = $category->uid;
        $record->save();
    }
}