<?php

class WP_Form_Element_Hidden_Test extends WP_UnitTestCase {

	public function test_create() {
		$element = WP_Form_Element::create('hidden');
		$this->assertInstanceOf('WP_Form_Element', $element);
		$this->assertInstanceOf('WP_Form_Element_Hidden', $element);
	}

	public function test_type() {
		$element = WP_Form_Element::create('hidden');
		$this->assertEquals('hidden', $element->get_type());
	}
}
