<?php

class WP_Form_View_Radios_Test extends WP_UnitTestCase {
	public function test_type_match() {
		$element = WP_Form_Element::create('radios')->set_name('green')->add_option('red', 'Blue');
		$radios_view = new WP_Form_View_Radios();

		$element->set_view($radios_view);
		$this->assertNotEmpty($element->render());
	}

	public function test_options() {
		/** @var WP_Form_Element_Radios $element */
		$element = WP_Form_Element::create('radios')->set_name('my-radios');
		$element
			->add_option( 'red', 'Crimson' )
			->add_option( 'blue', 'Blue' )
			->add_option( 'yellow', 'Bright Yellow', 3 );

		$output = $element->render();

		$this->assertTag(
			array(
				'tag' => 'label',
				'attributes' => array(
					'for' => 'my-radios-red',
				),
				'content' => 'Crimson',
				'child' => array(
					'tag' => 'input',
					'id' => 'my-radios-red',
				)
			),
			$output
		);
	}
}
