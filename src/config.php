<?php
/**
 * Seeder plugin for Craft CMS 3.x
 *
 * Entries seeder for Craft CMS
 *
 * @link      https://studioespresso.co
 * @copyright Copyright (c) 2018 Studio Espresso
 */

return [
    "eachMatrixBlock" => false,
    "useLocalAssets" => false,
    "sets" => [
        'default' => [
            'Users' => [
                // groupId => count
                1 => 10
            ],
            "Entries" => [
                // sectionId => count
                1 => 20,
            ]
        ],
    ],
];
