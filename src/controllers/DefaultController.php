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

use studioespresso\seeder\Seeder;

use Craft;
use craft\web\Controller;

/**
 * @author    studioespresso
 * @package   Seeder
 * @since     1.0.0
 */
class DefaultController extends Controller
{
	// Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $result = 'Welcome to the DefaultController actionIndex() method';

        return $result;
    }

}
