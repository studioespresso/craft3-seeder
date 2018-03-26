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
use craft\fields\Assets as AssetsField;
use craft\fields\Email;
use craft\fields\Matrix;
use craft\fields\PlainText;
use craft\fields\Url;
use craft\helpers\Assets;
use craft\models\VolumeFolder;
use craft\services\Path;
use craft\models\MatrixBlockType;
use craft\web\UploadedFile;
use Faker\Factory;
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
class Fields extends Component  {

	public $factory;

	public function __construct() {
		$this->factory = Factory::create();

	}

	public function Title() {
		$title = $this->factory->realText(rand(15, 40));
		$title = substr($title, 0, strlen($title) - 1);
		return $title;
	}

	/**
	 * @param PlainText $field
	 */
	public function PlainText($field) {
		return $this->factory->realText($field->charLimit ? $field->charLimit : 200);
	}

	/**
	 * @param Email $field
	 */
	public function Email($field) {
		return $this->factory->email();
	}

	/**
	 * @param Url $field
	 **/
	public function Url($field) {
		return $this->factory->url();
	}


	/**
	 * @param AssetsField $field
	 */
	public function Assets($field) {
		$assets = [];


		$path = new Path();
		$dir = $path->getTempAssetUploadsPath() . '/seeder/';
		if(!is_dir($dir)){ mkdir($dir); }

		$folder = explode(':', $field->defaultUploadLocationSource);
		$folderId = $folder[1];
		$assetFolder = Craft::$app->assets->getFolderById($folderId);

		for ( $x = 1; $x <= $field->limit; $x ++ ) {


			$image = $this->factory->imageUrl(1600,1200);
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
			$assets[] = $result->id;
		}

		return $assets;

	}

	/**
	 * @param Matrix $field
	 */
	public function Matrix($field) {
		/* @var $blockType MatrixBlockType*/
		foreach($field->getBlockTypes() as $blockType) {
			$blockTypeLayout = $blockType->fieldLayoutId;

		}
	}

	private function uploadNewAsset($folderId, $path) {


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