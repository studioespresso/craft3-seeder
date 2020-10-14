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

use Craft;
use craft\base\Component;
use craft\elements\Asset;
use craft\elements\Category;
use craft\elements\Entry;
use craft\elements\MatrixBlock;
use craft\elements\Tag;
use craft\errors\FieldNotFoundException;
use craft\fields\Assets as AssetsField;
use craft\fields\Categories;
use craft\fields\Checkboxes;
use craft\fields\Dropdown;
use craft\fields\Email;
use craft\fields\Entries;
use craft\fields\Lightswitch;
use craft\fields\Matrix;
use craft\fields\MultiSelect;
use craft\fields\Number;
use craft\fields\PlainText;
use craft\fields\RadioButtons;
use craft\fields\Table;
use craft\fields\Tags;
use craft\fields\Url;
use craft\fields\Users;
use craft\helpers\Assets;
use craft\records\VolumeFolder;
use craft\services\Path;
use Faker\Factory;
use studioespresso\seeder\Seeder;

/**
 * Fields Service
 *
 * @author    Studio Espresso
 * @package   Seeder
 * @since     1.0.0
 */
class Fields extends Component
{

    public $factory;

    public $settings;

    public function __construct()
    {
        $this->factory = Factory::create();
        $this->settings = Seeder::$plugin->getSettings();
    }

    public function Title($maxLength = 40)
    {
        $title = $this->factory->text(rand(8, $maxLength));
        $title = substr($title, 0, strlen($title) - 1);
        return $title;
    }

    /**
     * @param PlainText $field
     * @param Entry $entry
     */
    public function PlainText($field, $entry)
    {
        $configValue = $this->getFieldConfig($field, $entry);
        if ($configValue) {
            return $configValue;
        }

        return $this->factory->realText($field->charLimit ? $field->charLimit : 200);
    }

    /**
     * @param Email $field
     */
    public function Email($field, $entry)
    {
        return $this->factory->email();
    }

    /**
     * @param Url $field
     **/
    public function Url($field, $entry)
    {
        return $this->factory->url();
    }

    public function Color($field, $entry)
    {
        return $this->factory->safeHexColor;

    }

    public function Date($field, $entry)
    {
        return $this->factory->dateTime();

    }

    /**
     * @param Categories $field
     * @param Entry $entry
     */
    public function Categories($field, $entry)
    {
        $configValue = $this->getFieldConfig($field, $entry);
        if ($configValue) {
            return $configValue;
        }

        $source = explode(":", $field->source);
        $catGroup = Craft::$app->getCategories()->getGroupByUid($source[1]);
        $cats = Category::find()
            ->groupId($catGroup->id)
            ->ids();

        $categories = [];
        if ($cats) {
            for ($x = 1; $x <= $field->branchLimit; $x++) {
                $categories[] = $cats[array_rand($cats)];
            }
        }
        return $categories;
    }

    /**
     * @param Dropdown $field
     * @param Entry $entry
     *
     */
    public function Dropdown($field, $entry)
    {
        $configValue = $this->getFieldConfig($field, $entry);
        if ($configValue) {
            return $configValue;
        }

        return $field->options[array_rand($field->options)]['value'];
    }

    /**
     * @param Checkboxes $field
     * @param Entry $entry
     */
    public function Checkboxes($field, $entry)
    {
        $configValue = $this->getFieldConfig($field, $entry);
        if ($configValue) {
            return $configValue;
        }

        $checkedBoxes = [];
        for ($x = 1; $x <= rand(1, count($field->options)); $x++) {
            $checkedBoxes[] = $field->options[array_rand($field->options)]['value'];
        }
        return $checkedBoxes;
    }

    /**
     * @param Number $field
     * @param Entry $entry
     */
    public function Number($field, $entry)
    {
        $configValue = $this->getFieldConfig($field, $entry);
        if ($configValue) {
            return $configValue;
        }

        return rand($field->min, $field->max ? $field->max : 100);
    }

    /**
     * @param RadioButtons $field
     * @param Entry $entry
     */
    public function RadioButtons($field, $entry)
    {
        $configValue = $this->getFieldConfig($field, $entry);
        if ($configValue) {
            return $configValue;
        }

        return $field->options[array_rand($field->options)]['value'];
    }

    /**
     * @param MultiSelect $field
     * @param Entry $entry
     */
    public function MultiSelect($field, $entry)
    {
        $options = [];
        for ($x = 1; $x <= rand(1, count($field->options)); $x++) {
            $options[] = $field->options[array_rand($field->options)]['value'];
        }
        return $options;
    }

    /**
     * @param Lightswitch $field
     * @param Entry $entry
     */
    public function Lightswitch($field, $entry)
    {
        return $this->factory->boolean;
    }

    /**
     * @param Table $field
     * @param Entry $entry
     */
    public function Table($field, $entry)
    {

        if ($field->minRows) {
            $min = $field->minRows;
        } else {
            $min = 1;
        }
        if ($field->maxRows) {
            $max = $field->maxRows;
        } else {
            $max = $min + 10;
        }

        $table = [];
        for ($x = 0; $x <= rand($min, $max); $x++) {
            foreach ($field->columns as $handle => $col) {
                switch ($col['type']) {
                    case "singleline":
                        $table[$x][$handle] = $this->factory->text(30);
                        break;
                    case "multiline":
                        $table[$x][$handle] = $this->factory->realText(150, rand(2, 5));
                        break;
                    case "lightswitch":
                        $table[$x][$handle] = $this->factory->boolean;
                        break;
                    case "number":
                        $table[$x][$handle] = $this->factory->numberBetween(2, 30);
                        break;
                    case "checkbox":
                        $table[$x][$handle] = $this->factory->boolean;
                        break;
                    case "date":
                        $table[$x][$handle] = $this->factory->dateTime;
                        break;
                    case "time":
                        $table[$x][$handle] = $this->factory->dateTime;
                        break;
                    case "color":
                        $table[$x][$handle] = $this->factory->hexColor;
                        break;
                }
            }
        }
        return $table;
    }

    /**
     * @param Tags $field
     * @param Entry $entry
     */
    public function Tags($field, $entry)
    {
        $tags = [];
        for ($x = 1; $x <= rand(1, 5); $x++) {
            $tag = new Tag();
            $tag->groupId = $field->groupId;
            $tag->title = $this->title();
            Craft::$app->elements->saveElement($tag);
            $tags[] = $tag->id;
        }
        return $tags;
    }

    /**
     * @param Users $field
     * @param Entry $entry
     */
    public function Users($field, $entry)
    {
        throw new FieldNotFoundException('Users field not supported');
    }

    /**
     * @param Entries $field
     * @param Entry $entry
     */
    public function Entries($field, $entry)
    {
        $configValue = $this->getFieldConfig($field, $entry);
        if ($configValue) {
            return $configValue;
        }

        $criteria = Entry::find($field->getSettings());
        $criteria->limit = $field->limit;
        return $criteria->ids();
    }

    /**
     * @param AssetsField $field
     */
    public function Assets($field, $entry)
    {
        $assets = [];

        if ($field->limit) {
            $limit = $field->limit;
        } else {
            $limit = 5;
        }

        if (Seeder::getInstance()->getSettings()->useLocalAssets) {
            $assetSettings = Seeder::getInstance()->getSettings()->useLocalAssets;
            $folder = VolumeFolder::findOne([
                'volumeId' => $assetSettings['volumeId'],
                'path' => $assetSettings['path'] ?? ''
            ]);

            $localAssets = Asset::find();
            $localAssets->orderBy('RAND()');
            $localAssets->folderId($folder->id);
            $localAssets->limit($limit);
            $assets = array_values($localAssets->ids());

        } else {
            $path = new Path();
            $dir = $path->getTempAssetUploadsPath() . '/seeder/';
            if (!is_dir($dir)) {
                mkdir($dir);
            }

            $folder = explode(':', $field->defaultUploadLocationSource);
            $folderUid = $folder[1];
            $assetFolder = Craft::$app->volumes->getVolumeByUid($folderUid);

            for ($x = 1; $x <= rand(1, $limit); $x++) {

                $image = $this->factory->imageUrl(1600, 1200, null, true);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $image);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                $picture = curl_exec($ch);
                curl_close($ch);

                $tmpImage = 'photo-' . rand() . '.jpg';
                $tempPath = $dir . $tmpImage;
                $saved = file_put_contents($tempPath, $picture);

                $result = $this->uploadNewAsset($assetFolder->id, $tempPath);
                Seeder::$plugin->seeder->saveSeededAsset($result);
                $assets[] = $result->id;
            }
        }

        return $assets;

    }

    /**
     * @param Matrix $field
     */
    public function Matrix($field, $entry)
    {
        $types = $field->getBlockTypes();

        $blockIds = [];
        $types = array_map(function ($type) {
            return $type->id;
        }, $types);

        if (Seeder::getInstance()->getSettings()->eachMatrixBlock) {
            $blockCount = count($types);
            for ($x = 0; $x < $blockCount; $x++) {
                $blockIds[] = $types[$x];
            }
            shuffle($blockIds);
        } else {
            $blockCount = rand(!empty($field->minBlocks) ? $field->minBlocks : 1, !empty($field->maxBlocks) ? $field->maxBlocks : 6);
            for ($x = 1; $x <= $blockCount; $x++) {
                $blockIds[] = $types[array_rand($types, 1)];
            }
        }

        foreach ($blockIds as $blockId) {
            $type = Craft::$app->matrix->getBlockTypeById($blockId);
            $blockTypeFields = Craft::$app->fields->getFieldsByLayoutId($type->fieldLayoutId);
            $matrixBlock = new MatrixBlock();
            $matrixBlock->typeId = $type->id;
            $matrixBlock->fieldId = $field->id;
            $matrixBlock->ownerId = $entry->id;
            Craft::$app->elements->saveElement($matrixBlock);
            $matrixBlock = Seeder::$plugin->seeder->populateFields($blockTypeFields, $matrixBlock);
            Craft::$app->elements->saveElement($matrixBlock);

        }
        return;
    }

    private function uploadNewAsset($folderId, $path)
    {
        $assets = Craft::$app->getAssets();
        $folder = $assets->findFolder(['id' => $folderId]);

        if (!$folder) {
            throw new BadRequestHttpException('The target folder provided for uploading is not valid');
        }

        // Check the permissions to upload in the resolved folder.
        $filename = Assets::prepareAssetName($path);

        $asset = new Asset();
        $asset->tempFilePath = $path;
        $asset->filename = $filename;
        $asset->newFolderId = $folder->id;
        $asset->volumeId = $folder->volumeId;
        $asset->avoidFilenameConflicts = true;
        $asset->setScenario(Asset::SCENARIO_CREATE);

        $result = Craft::$app->getElements()->saveElement($asset);

        return $asset;
    }

    private function getFieldConfig($field, $entry)
    {
        if (isset($this->settings->fields[$field->handle])) {
            if (isset($this->settings->fields[$field->handle]['mode'])) {
                $mode = $this->settings->fields[$field->handle]['mode'];
                if ($mode === "random") {
                    $key = array_rand($this->settings->fields[$field->handle]['value']);
                    return [$this->settings->fields[$field->handle]['value'][$key]];
                }
            } elseif (isset($this->settings->fields[$field->handle]['value'])) {
                return $this->settings->fields[$field->handle]['value'];
            }
        }
        return false;
    }
}