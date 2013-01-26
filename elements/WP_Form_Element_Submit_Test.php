<?php

class WP_Form_Element_Submit_Test extends WP_UnitTestCase {

	public function test_create() {
		$element = WP_Form_Element::create('submit');
		$this->assertInstanceOf('WP_Form_Element', $element);
		$this->assertInstanceOf('WP_Form_Element_Submit', $element);
	}

	public function test_type() {
		$element = WP_Form_Element::create('submit');
		$this->assertEquals('submit', $element->get_type());
	}
}
