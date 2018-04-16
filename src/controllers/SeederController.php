<?php
/**
 * Seeder plugin for Craft CMS 3.x
 *
 * Seeder
 *
 * @link      https://studioespresso.co
 * @copyright Copyright (c) 2018 studioespresso
 */

namespace studioespresso\seeder\controllers;

use studioespresso\seeder\models\SeederEntryModel;
use studioespresso\seeder\records\SeederAssetRecord;
use studioespresso\seeder\records\SeederEntryRecord;
use studioespresso\seeder\Seeder;

use Craft;
use craft\web\Controller;

/**
 * @author    studioespresso
 * @package   Seeder
 * @since     1.0.0
 */
class SeederController extends Controller
{
	// Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $data = [];
        $sections = Craft::$app->getSections();
        foreach($sections->getAllSections() as $section) {
        	$seededEntries = SeederEntryRecord::findAll( [
        		    'section' => $section->id
		        ] );
	        if(count($seededEntries)) {
	        	$data['sections'][$section->id]['id'] = $section->id;
	        	$data['sections'][$section->id]['name'] = $section->name;
	        	$data['sections'][$section->id]['count'] = count($seededEntries);
	        }
        }

        $seededAssets = SeederAssetRecord::find();
        if($seededAssets->count()) {
        	$data['assets']['count'] = $seededAssets->count();
        }


        return $this->renderTemplate('seeder/_index', [ 'data' => $data]);
    }

    public function actionClean() {
    	$data = Craft::$app->request->post('data');
		if($data) {
			if(!empty($data['sections'])) {
				foreach($data['sections'] as $sectionId) {
					$seededEntries = SeederEntryRecord::findAll( [
						'section' => $sectionId
					] );
					foreach($seededEntries as $entry) {
						Craft::$app->elements->deleteElementById($entry->entryId);
						SeederEntryRecord::deleteAll(['entryId' => $entry->entryId]);
					}
					Craft::$app->session->setFlash('Entries clean up');
				}
			}
			if(!empty($data['assets'])) {
				$seededAssets = SeederAssetRecord::find();
				foreach($seededAssets->all() as $asset) {
					Craft::$app->elements->deleteElementById($asset->assetId);
					SeederAssetRecord::deleteAll(['assetId' => $asset->assetId]);
				}
			}
		}
		exit;
		return $this->redirectToPostedUrl();
    }

}
