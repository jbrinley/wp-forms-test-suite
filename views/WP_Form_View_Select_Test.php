<?php

class WP_Form_View_Select_Test extends WP_UnitTestCase {
	public function test_type_match() {
		$element = WP_Form_Element::create('select');
		$select_view = new WP_Form_View_Select();

		$element->set_view($select_view);
		$this->assertNotEmpty($element->render());
	}

	public function test_options() {
		/** @var WP_Form_Element_Select $element */
		$element = WP_Form_Element::create('select')->set_name('my-select');
		$element
			->add_option( 'red', 'Crimson' )
			->add_option( 'blue', 'Blue' )
			->add_option( 'yellow', 'Bright Yellow', 3 );

		$output = $element->render();

		$this->assertTag(
			array(
				'tag' => 'select',
				'attributes' => array(
					'name' => 'my-select',
				),
				'children' => array(
					'count' => 3,
				)
			),
			$output
		);
	}
}
