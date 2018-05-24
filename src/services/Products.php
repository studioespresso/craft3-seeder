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

use craft\commerce\elements\Product;
use craft\commerce\services\ProductTypes;
use craft\elements\Asset;
use craft\elements\Entry;
use craft\errors\FieldNotFoundException;
use Faker\Factory;
use studioespresso\seeder\Seeder;

use Craft;
use craft\base\Component;
use yii\base\Model;

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
class Products extends Component
{

    private $productTypes;
    /**
     * @param null $sectionId
     *
     * @throws \Throwable
     * @throws \craft\errors\ElementNotFoundException
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct(array $config = [])
    {
        $this->productTypes = new ProductTypes();
    }

    public function generate($type, $count)
    {
        if(is_string($type)) {
            if(!$this->productTypes->getProductTypeByHandle($type)) {
                return "Product type not found.\n";
            }
            $productType = $this->productTypes->getProductTypeByHandle($type);
        } elseif (is_int($type)) {
            if(!$this->productTypes->getProductTypeById($type)) {
                return "Product type not found.\n";
            }
            $productType = $this->productTypes->getProductTypeById($type);
        }

    }


}