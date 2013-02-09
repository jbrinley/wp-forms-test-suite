<?php

class WP_Form_View_Checkboxes_Test extends WP_UnitTestCase {
	public function test_type_match() {
		/** @var WP_Form_Element_Checkboxes $element */
		$element = WP_Form_Element::create('checkboxes')->set_name('green')->add_option('red', 'Blue');
		$view = new WP_Form_View_Checkboxes();
		$element->set_view($view);

		$this->assertNotEmpty($element->render());
	}

	public function test_options() {
		/** @var WP_Form_Element_Checkboxes $element */
		$element = WP_Form_Element::create('checkboxes')->set_name('my-checkboxes');
		$element
			->add_option( 'red', 'Crimson' )
			->add_option( 'blue', 'Blue' )
			->add_option( 'yellow', 'Bright Yellow', 3 );

		$output = $element->render();

		$this->assertTag(
			array(
				'tag' => 'label',
				'attributes' => array(
					'for' => 'my-checkboxes-red',
				),
				'content' => 'Crimson',
				'child' => array(
					'tag' => 'input',
					'id' => 'my-checkboxes-red',
					'attributes' => array(
						'name' => 'my-checkboxes[]',
						'value' => 'red',
					),
				)
			),
			$output
		);
	}
}
