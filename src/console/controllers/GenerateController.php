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
 * Default Command
 *
 * The first line of this class docblock is displayed as the description
 * of the Console Command in ./craft help
 *
 * Craft can be invoked via commandline console by using the `./craft` command
 * from the project root.
 *
 * Console Commands are just controllers that are invoked to handle console
 * actions. The segment routing is plugin-name/controller-name/action-name
 *
 * The actionIndex() method is what is executed if no sub-commands are supplied, e.g.:
 *
 * ./craft seeder/default
 *
 * Actions must be in 'kebab-case' so actionDoSomething() maps to 'do-something',
 * and would be invoked via:
 *
 * ./craft seeder/default/do-something
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
	 * Generates categories
	 *
	 * The first line of this method docblock is displayed as the description
	 * of the Console Command in ./craft help
	 *
	 * @return mixed
	 */
	public function actionCategoeis($section = null, $count = 20)
	{
		$result = Seeder::$plugin->entries->generate($section, $count);

		return $result;
	}
}
