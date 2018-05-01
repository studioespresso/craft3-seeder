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

use studioespresso\seeder\Seeder;

use Craft;
use studioespresso\seeder\services\Seeder_EntriesService;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Seeder plugin
 *
 * This plugin allows you to quickly create dummy or test data that you can use while building your site.
 *
 * @author    Studio Espresso
 * @package   Seeder
 * @since     1.0.0
 */
class GenerateController extends Controller
{
    // Public Methods
    // =========================================================================

    /**
     * Generates entries for the specified section
     *
     * The first line of this method docblock is displayed as the description
     * of the Console Command in ./craft help
     *
     * @return mixed
     */
    public function actionEntries($section = null, $count = 20)
    {
		$result = Seeder::$plugin->entries->generate($section, $count);

        return $result;
    }

	/**
	 * Generates categories for the specified group
	 *
	 * The first line of this method docblock is displayed as the description
	 * of the Console Command in ./craft help
	 *
	 * @return mixed
	 */
	public function actionCategories($group = null, $count = 20)
	{
		$result = Seeder::$plugin->categories->generate($group, $count);

		return $result;
	}

    /**
     * Generates categories for the specified group
     *
     * The first line of this method docblock is displayed as the description
     * of the Console Command in ./craft help
     *
     * @return mixed
     */
    public function actionUsers($group = null, $count = 5)
    {
        if (Craft::$app->getEdition() != Craft::Pro) {
            echo "Users requires your Craft install to be upgrade to Pro. You can trial this in the control panel";
            exit();
        }
        $result = Seeder::$plugin->users->generate($group, $count);
        return $result;
    }
}
