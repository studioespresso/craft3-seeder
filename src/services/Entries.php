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
use craft\elements\Entry;
use craft\errors\FieldNotFoundException;
use Faker\Factory;
use Faker\Provider\Person;
use studioespresso\seeder\Seeder;

use Craft;
use craft\base\Component;
use yii\base\Model;
use yii\helpers\Console;

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
    public function generate($section = null, $count)
    {
        if (ctype_digit($section)) {
            $section = Craft::$app->sections->getSectionById((int)$section);
        } else {
            $section = Craft::$app->sections->getSectionByHandle($section);
        }

        if (!$section) {
            echo "Section not found\n";
            return false;
        }
        $faker = Factory::create();

        $entryTypes = $section->getEntryTypes();
        $current = 0;
        $total = count($entryTypes) * $count;
        Console::startProgress($current, $count);
        foreach ($section->getEntryTypes() as $entryType) {
            for ($x = 1; $x <= $count; $x++) {
                $current++;
                Console::updateProgress($current, $count);
                $typeFields = Craft::$app->fields->getFieldsByLayoutId($entryType->getFieldLayoutId());
                $entry = new Entry([
                    'sectionId' => (int)$section->id,
                    'typeId' => $entryType->id,
                    'title' => Seeder::$plugin->fields->Title(),
                ]);
                Craft::$app->getElements()->saveElement($entry);
                Seeder::$plugin->seeder->saveSeededEntry($entry);
                $entry = Seeder::$plugin->seeder->populateFields($typeFields, $entry);
                Craft::$app->getElements()->saveElement($entry);
            }
        }
        Console::endProgress();
        return $section->name;

    }

}