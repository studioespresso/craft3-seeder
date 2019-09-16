<?php
/**
 * Seeder plugin for Craft CMS 3.x
 *
 * Weeder service for Craft CMS
 *
 * @link      https://studioespresso.co
 * @copyright Copyright (c) 2018 Studio Espresso
 */

namespace studioespresso\seeder\services;

use Craft;
use craft\base\Component;
use craft\elements\Asset;
use craft\elements\Category;
use craft\elements\Entry;
use craft\elements\User;
use studioespresso\seeder\records\SeederAssetRecord;
use studioespresso\seeder\records\SeederCategoryRecord;
use studioespresso\seeder\records\SeederEntryRecord;
use studioespresso\seeder\records\SeederUserRecord;

/**
 * Weeder Service
 *
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Studio Espresso
 * @package   Seeder
 * @since     1.0.0
 */
class Weeder extends Component
{

    public function entries($sectionId)
    {
        $seededEntries = SeederEntryRecord::findAll([
            'section' => $sectionId
        ]);
        $section = Craft::$app->sections->getSectionById($sectionId);
        foreach ($seededEntries as $seededEntry) {
            $entry = Entry::find()
                ->uid($seededEntry->entryUid)
                ->section($section->handle)
                ->one();
            if ($entry) {
                Craft::$app->elements->deleteElement($entry);
            }
            SeederEntryRecord::deleteAll(['entryUid' => $seededEntry->entryUid]);
        }
    }

    public function categories()
    {
        $seededCategories = SeederCategoryRecord::find();
        foreach ($seededCategories->all() as $seededCategory) {
            $category = Category::find()
                ->uid($seededCategory->categoryUid)
                ->one();
            if ($category) {
                Craft::$app->elements->deleteElement($category);
            }
            SeederCategoryRecord::deleteAll(['categoryUid' => $seededCategory->categoryUid]);
        }
    }

    public function assets()
    {
        $seededAssets = SeederAssetRecord::find();
        foreach ($seededAssets->all() as $seededAsset) {
            $asset = Asset::find()
                ->uid($seededAsset->assetUid)
                ->one();
            if ($asset) {
                Craft::$app->elements->deleteElement($asset);
                SeederAssetRecord::deleteAll(['assetUid' => $seededAsset->assetUid]);
            }
        }
    }

    public function users()
    {
        $seededUsers = SeederUserRecord::find();
        foreach ($seededUsers->all() as $seededUser) {
            $user = User::find()
                ->uid($seededUser->userUid)
                ->one();
            if ($user) {
                Craft::$app->elements->deleteElement($user);
            }
            SeederUserRecord::deleteAll(['userUid' => $seededUser->userUid]);
        }
    }
}