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

use Faker\Factory;
use Faker\Provider\Base;
use Faker\Provider\Lorem;
use studioespresso\seeder\Seeder;
use statikbe\cta\CTA as CTAPlugin;

use Craft;
use craft\base\Component;

/**
 * Fields Service
 *
 * @author    Studio Espresso
 * @package   Seeder
 * @since     1.0.0
 */
class CTA extends Component
{

    public $factory;

    public function __construct()
    {
        $this->factory = Factory::create();
    }

    public function CTAField(\statikbe\cta\fields\CTAField $field, $entry)
    {
        
        $customLabel = $field->allowCustomText;
        $blank = $field->allowTarget;

        $attr = [
            'allowCustomText' => $field->allowCustomText,
            'allowTarget' => $field->allowTarget,
            'defaultText' => $field->defaultText,
            'owner' => $entry,
        ];

        if (CTAPlugin::$plugin->getSettings()->classes) {
            $classes = CTAPlugin::$plugin->getSettings()->classes;
        } else {
            $classes = [
                'btn' => 'Primary',
                'btn btn--secondary' => 'Secondary',
                'btn btn--ghost' => 'Ghost',
                'link link--ext' => 'Link >',
                'link' => 'Link'
            ];
        }

        $attr += [
            'customText' => $field->allowCustomText ? $this->factory->realText(20) : null,
            'target' => $field->allowTarget ? $this->factory->boolean : null,
            'class' => array_rand($classes),
        ];

        if ((is_array($field->allowedLinkNames)  && in_array('url', $field->allowedLinkNames)) || $field->allowedLinkNames === '*' ) {
            $attr['type'] = 'url';
            $attr['value'] = $this->factory->url;
        } elseif (in_array('email', $field->allowedLinkNames)) {
            $attr['type'] = 'email';
            $attr['value'] = $this->factory->email;
        }
        return new \statikbe\cta\models\CTA($attr);
    }
}