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

use Craft;
use craft\base\Component;
use craft\errors\FieldNotFoundException;
use studioespresso\seeder\records\SeederAssetRecord;
use studioespresso\seeder\records\SeederCategoryRecord;
use studioespresso\seeder\records\SeederEntryRecord;
use studioespresso\seeder\records\SeederUserRecord;
use studioespresso\seeder\Seeder;

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
class SeederService extends Component
{
    /**
     * @param $fields
     * @param Entry $entry
     */
    public function populateFields($fields, $entry)
    {
        $entryFields = [];
        foreach ($fields as $field) {
            if(isset(Seeder::$plugin->getSettings()->fields[$field->handle]) &&
                Seeder::$plugin->getSettings()->fields[$field->handle] == 'ignore') {
                continue;
            }
            try {
                $fieldData = $this->isFieldSupported($field);
                if ($fieldData) {
                    $fieldProvider = $fieldData[0];
                    $fieldType = $fieldData[1];
                    $entryFields[$field['handle']] = Seeder::$plugin->$fieldProvider->$fieldType($field, $entry);
                }
            } catch (FieldNotFoundException $e) {
                if (Seeder::$plugin->getSettings()->debug) {
                    dd($e);
                } else {
                    Craft::warning("Fieldtype not supported: $fieldType", __CLASS__);
                }
            }
        }
        $entry->setFieldValues($entryFields);

        return $entry;

    }

    /**
     * @param Entry $entry
     */
    public function saveSeededEntry($entry)
    {
        $record = new SeederEntryRecord();
        $record->entryUid = $entry->uid;
        $record->section = $entry->sectionId;
        $record->save();
    }

    /**
     * @param Asset $asset
     */
    public function saveSeededAsset($asset)
    {
        $record = new SeederAssetRecord();
        $record->assetUid = $asset->uid;
        $record->save();
    }

    /**
     * @param User $user
     */
    public function saveSeededUser($user)
    {
        $record = new SeederUserRecord();
        $record->userUid = $user->uid;
        $record->save();
    }

    /**
     * @param Asset $asset
     */
    public function saveSeededCategory($category)
    {
        $record = new SeederCategoryRecord();
        $record->section = $category->groupId;
        $record->categoryUid = $category->uid;
        $record->save();
    }

    private function isFieldSupported($field)
    {
        $fieldType = explode('\\', get_class($field));
        $fieldProvider = $fieldType[1];
        $fieldType = end($fieldType);

        if (class_exists('studioespresso\\seeder\\services\\fields\\' . $fieldProvider)) {
            if (in_array($fieldType, get_class_methods(Seeder::getInstance()->$fieldProvider))) {
                return [$fieldProvider, $fieldType];
            } else {
                if (Seeder::$plugin->getSettings()->debug) {
                    throw new FieldNotFoundException('Fieldtype not supported: ' . $fieldType);
                } else {
                    Craft::warning("Fieldtype not supported: $fieldType", __CLASS__);
                }
            }
        } else {
            if (Seeder::$plugin->getSettings()->debug) {
                throw new FieldNotFoundException('Fieldtype not supported: ' . $fieldType);
            } else {
                Craft::warning("Fieldtype not supported: $fieldType", __CLASS__);
            }
        }
    }

}
