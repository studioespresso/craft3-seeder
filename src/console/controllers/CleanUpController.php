<?php
/**
 * Seeder plugin for Craft CMS 3.x
 *
 * Entries seeder for Craft CMS
 *
 * @link      https://studioespresso.co
 * @copyright Copyright (c) 2018 Studio Espresso
 */

namespace studioespresso\seeder\console\controllers;

use Craft;
use studioespresso\seeder\records\SeederEntryRecord;
use studioespresso\seeder\Seeder;
use studioespresso\seeder\services\Seeder_EntriesService;
use yii\console\Controller;

/**
 * Seeder plugin
 *
 * This plugin allows you to quickly create dummy or test data that you can use while building your site.
 *
 * @author    Studio Espresso
 * @package   Seeder
 * @since     1.0.0
 */
class CleanUpController extends Controller
{
    // Public Methods
    // =========================================================================

    /**
     * Clean up all seeded elements
     *
     * The first line of this method docblock is displayed as the description
     * of the Console Command in ./craft help
     *
     * @return mixed
     */
    public function actionAll()
    {
        $sections = Craft::$app->getSections();
        foreach ($sections->getAllSections() as $section) {
            $seededEntries = SeederEntryRecord::findAll([
                'section' => $section->id
            ]);
            if (count($seededEntries)) {
                Seeder::$plugin->weeder->entries($section->id);
            }
        }

        Seeder::$plugin->weeder->assets();
        Seeder::$plugin->weeder->users();

    }

}
