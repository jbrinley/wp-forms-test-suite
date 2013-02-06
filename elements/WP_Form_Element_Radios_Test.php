<?php

class WP_Form_Element_Radios_Test extends WP_UnitTestCase {
	public function test_create() {
		$element = WP_Form_Element::create('radios');
		$this->assertInstanceOf('WP_Form_Element', $element);
		$this->assertInstanceOf('WP_Form_Element_Radios', $element);
	}

	public function test_options() {
		/** @var WP_Form_Element_Radios $element */
		$element = WP_Form_Element::create('radios');
		$element
			->add_option( 'red', 'Crimson' )
			->add_option( 'blue', 'Blue' )
			->add_option( 'yellow', 'Bright Yellow', 3 );
		$options = $element->get_options();

		$this->assertCount(3, $options);
		$this->assertEquals(array('yellow', 'red', 'blue'), array_keys($options));
		$this->assertEquals(array('Bright Yellow', 'Crimson', 'Blue'), array_values($options));
	}
}
