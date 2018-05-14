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

use craft\elements\Entry;
use studioespresso\seeder\models\SeederEntryModel;
use studioespresso\seeder\records\SeederAssetRecord;
use studioespresso\seeder\records\SeederEntryRecord;
use studioespresso\seeder\records\SeederUserRecord;
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

        $seededUsers = SeederUserRecord::find();
        if($seededUsers->count()) {
            $data['users']['count'] = $seededUsers->count();
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
					$section = Craft::$app->sections->getSectionById($sectionId);
					foreach($seededEntries as $seededEntry) {
                        $entry = Entry::find()
                            ->uid($seededEntry->entryUid)
                            ->section($section->handle)
                            ->one();
                        Craft::$app->elements->deleteElement($entry);
						SeederEntryRecord::deleteAll(['entryUid' => $seededEntry->entryUid]);
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
            if(!empty($data['users'])) {
                $seededUsers = SeederUserRecord::find();
                foreach($seededUsers->all() as $user) {
                    Craft::$app->elements->deleteElementById($user->userId);
                    SeederUserRecord::deleteAll(['userId' => $user->userId]);
                }
            }
		}
		return $this->redirectToPostedUrl();
    }

}
