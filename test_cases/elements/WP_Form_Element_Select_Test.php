<?php

class WP_Form_Element_Select_Test extends WP_UnitTestCase {
	public function test_create() {
		$element = WP_Form_Element::create('select');
		$this->assertInstanceOf('WP_Form_Element', $element);
		$this->assertInstanceOf('WP_Form_Element_Select', $element);
	}

	public function test_options() {
		/** @var WP_Form_Element_Select $element */
		$element = WP_Form_Element::create('select');
		$element
			->add_option( 'red', 'Crimson' )
			->add_option( 'blue', 'Blue' )
			->add_option( 'yellow', 'Bright Yellow', 3 );
		$options = $element->get_options();

		$this->assertCount(3, $options);
		$this->assertEquals(array('yellow', 'red', 'blue'), array_keys($options));
		$this->assertEquals(array('Bright Yellow', 'Crimson', 'Blue'), array_values($options));
	}

	public function test_optgroups() {
		/** @var WP_Form_Element_Select $element */
		$element = WP_Form_Element::create('select');
		$element
			->add_option( 'Warm', array(
				'red' => 'Red',
				'orange' => 'Orange',
				'yellow' => 'Yellow',
			) )
			->add_option( 'Cold', array(
				'green' => 'Green',
				'blue' => 'Blue',
				'purple' => 'Purple',
			) );
		$options = $element->get_options();

		$this->assertCount(2, $options);
		$this->assertEquals(array('Warm', 'Cold'), array_keys($options));
		$this->assertEquals(array('red', 'orange', 'yellow'), array_keys($options['Warm']));
		$this->assertEquals(array('Green', 'Blue', 'Purple'), array_values($options['Cold']));
	}
}
