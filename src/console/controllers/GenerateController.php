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
use studioespresso\seeder\Seeder;
use studioespresso\seeder\services\Seeder_EntriesService;
use yii\console\Controller;

/**
 * Seeder for Craft CMS 3.x - by Studio Espresso
 *
 * This plugin allows you to quickly create dummy data that you can use while building your site.
 * Issues or feedback: https://github.com/studioespresso/craft3-seeder/issues
 *
 * @author    Studio Espresso
 * @package   Seeder
 * @since     1.0.0
 */
class GenerateController extends Controller
{

    /**
     * Section handle or id
     * @var String
     */
    public $section;

    /**
     * Categories or user group handle or id
     * @var String
     */
    public $group;

    /**
     * Number of entries to be seeded
     * @var Integer
     */
    public $count = 20;

    /**
     * Site ID of the site in which you want to seed entries
     * @var Integer
     */
    public $siteId = 1;

    // Public Methods
    // =========================================================================


    public function options($actionId)
    {
        switch ($actionId) {
            case 'entries':
                return ['section', 'siteId', 'count'];
            case 'categories':
                return ['group', 'count'];
            case 'users':
                return ['group', 'count'];
        }
    }

    /**
     * Generates entries for the specified section
     *
     * The first line of this method docblock is displayed as the description
     * of the Console Command in ./craft help
     *
     * @return mixed
     */
    public function actionEntries()
    {
        if (!$this->section) {
            echo "Section handle or id missing, please specify\n";
            return;
        }

        $result = Seeder::$plugin->entries->generate($this->section, $this->siteId, $this->count);
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
    public function actionCategories()
    {

        if (!$this->group) {
            echo "Group handle or id missing, please specify\n";
            return;
        }
        $result = Seeder::$plugin->categories->generate($this->group, $this->count);

        return $result;
    }

    /**
     * Generates users for the specified usergroup
     *
     * The first line of this method docblock is displayed as the description
     * of the Console Command in ./craft help
     *
     * @return mixed
     */
    public function actionUsers()
    {
        if (Craft::$app->getEdition() != Craft::Pro) {
            echo "Users requires your Craft install to be upgrade to Pro. You can trial Craft Pro in the control panel\n";
            return;
        }

        if (!$this->group) {
            echo "Group handle or id missing, please specify\n";
            return;
        }
        $result = Seeder::$plugin->users->generate($this->group, $this->count);
        return $result;
    }

    /**
     * Generates a set of elements predefined in your config/seeder.php
     *
     * The first line of this method docblock is displayed as the description
     * of the Console Command in ./craft help
     *
     * @return mixed
     */
    public function actionSet($name = 'default')
    {
        if (!array_key_exists($name, Seeder::$plugin->getSettings()->sets)) {
            echo "Set not found\n";
            return;
        }
        $settings = Seeder::$plugin->getSettings()->sets[$name];
        foreach ($settings as $type => $option) {
            d($type, $option);
            switch ($type) {
                case 'Users':
                    if (is_array($option)) {
                        foreach ($option as $group => $count) {
                            $result = Seeder::$plugin->users->generate($group, $count);
                            if ($result) {
                                echo "Seeded " . $count . " entries in " . $result . "\n";
                            }
                        }
                    }
                    break;
                case 'Entries':
                    if (is_array($option)) {
                        foreach ($option as $section => $count) {
                            $result = Seeder::$plugin->entries->generate($section, $count);
                            if ($result) {
                                echo "Seeded " . $count . " entries in " . $result . "\n";
                            }
                        }
                    }
                    break;
            }
        }
    }
}
