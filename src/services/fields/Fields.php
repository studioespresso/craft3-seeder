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

use craft\elements\Asset;
use craft\elements\Category;
use craft\elements\Entry;
use craft\elements\MatrixBlock;
use craft\elements\Tag;
use craft\fields\Assets as AssetsField;
use craft\fields\Categories;
use craft\fields\Checkboxes;
use craft\fields\Dropdown;
use craft\fields\Email;
use craft\fields\Lightswitch;
use craft\fields\Matrix;
use craft\fields\MultiSelect;
use craft\fields\PlainText;
use craft\fields\RadioButtons;
use craft\fields\Table;
use craft\fields\Tags;
use craft\fields\Url;
use craft\fields\Users;
use craft\helpers\Assets;
use craft\models\VolumeFolder;
use craft\services\Path;
use craft\models\MatrixBlockType;
use craft\web\UploadedFile;
use Faker\Factory;
use Faker\Provider\Text;
use studioespresso\seeder\Seeder;

use Craft;
use craft\base\Component;

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

    public function __construct()
    {
        $this->factory = Factory::create();

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
        $catGroup = Craft::$app->getCategories()->getGroupById($field->groupId);
        $cats = Category::find()
            ->groupId($field->groupId)
            ->ids();

        $categories = [];
        for ($x = 1; $x <= $field->branchLimit; $x++) {
            $categories[] = $cats[array_rand($cats)];
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
        return $field->options[array_rand($field->options)]['value'];
    }

    /**
     * @param Checkboxes $field
     * @param Entry $entry
     */
    public function Checkboxes($field, $entry)
    {
        $checkedBoxes = [];
        for ($x = 1; $x <= rand(1, count($field->options)); $x++) {
            $checkedBoxes[] = $field->options[array_rand($field->options)]['value'];
        }
        return $checkedBoxes;
    }

    /**
     * @param RadioButtons $field
     * @param Entry $entry
     */
    public function RadioButtons($field, $entry)
    {
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
        $table = [];
        for ($x = 0; $x <= rand($field->minRows - 1, $field->maxRows - 1); $x++) {
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
        foreach ($field->sources as $source) {
            d($source);
        }
        for ($x = 1; $x <= rand(1, $field->limit); $x++) {

        }
        exit;
    }

    /**
     * @param AssetsField $field
     */
    public function Assets($field, $entry)
    {
        $assets = [];

        $path = new Path();
        $dir = $path->getTempAssetUploadsPath() . '/seeder/';
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        $folder = explode(':', $field->defaultUploadLocationSource);
        $folderId = $folder[1];
        $assetFolder = Craft::$app->assets->getFolderById($folderId);

        for ($x = 1; $x <= $field->limit; $x++) {

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
            Seeder::$plugin->entries->saveSeededAsset($result);
            $assets[] = $result->id;
        }

        return $assets;

    }

    /**
     * @param Matrix $field
     */
    public function Matrix($field, $entry)
    {
        $types = $field->getBlockTypes();
        $blockCount = rand(!empty($field->minBlocks) ? $field->minBlocks : 1, !empty($field->maxBlocks) ? $field->maxBlocks : 6);
        $blockIds = [];
        $types = array_map(function ($type) {
            return $type->id;
        }, $types);

        for ($x = 1; $x <= $blockCount; $x++) {
            $blockIds[] = $types[array_rand($types, 1)];
        }
        foreach ($blockIds as $blockId) {
            $type = Craft::$app->matrix->getBlockTypeById($blockId);
            $blockTypeFields = Craft::$app->fields->getFieldsByLayoutId($type->fieldLayoutId);
            $matrixBlock = new MatrixBlock();
            $matrixBlock->typeId = $type->id;
            $matrixBlock->fieldId = $field->id;
            $matrixBlock->ownerId = $entry->id;
            $matrixBlock = Seeder::$plugin->entries->populateFields($blockTypeFields, $matrixBlock);
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
}