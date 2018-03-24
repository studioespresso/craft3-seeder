<?php

namespace studioespresso\seeder\models;

use yii\base\Model;


/**
 * Class SeederEntryModel
 * @package studioespresso\seeder\models
 */
class SeederEntryModel extends Model {


	/**
	 * @return array
	 */
	public function rules() {
		return [
			[
				[
					'id',
					'entryId',
					'section',
				],
				'safe',
			],
		];
	}

	/**
	 *  Address ID
	 *
	 * @var
	 */
	public $id;

	public $entry;

	public $section;

}