<?php
namespace studioespresso\seeder;

use craft\elements\Entry;
use craft\fields\Lightswitch;
use studioespresso\seeder\services\fields\Fields;

class FieldTest extends \Codeception\Test\Unit {
	/**
	 * @var \UnitTester
	 */
	protected $tester;

	protected $field;

	protected $entry;

	protected function _before() {
		$this->field = new Fields();
		$this->entry = $this->getMockBuilder(Entry::class)->getMock();
	}

	public function testLightswitchField() {
		$field = $this->getMockBuilder(Lightswitch::class)->getMock();
		$this->assertInternalType('boolean', $this->field->Lightswitch($field, $this->entry));
	}

	protected function _after() {
	}
	
}