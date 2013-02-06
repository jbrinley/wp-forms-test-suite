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

	public function test_optgroups() {
		/** @var WP_Form_Element_Select $element */
		$element = WP_Form_Element::create('select')->set_name('my-select');
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
		$output = $element->render();

		$this->assertTag(
			array(
				'tag' => 'select',
				'attributes' => array(
					'name' => 'my-select',
				),
				'children' => array(
					'count' => 2,
				)
			),
			$output
		);
		$this->assertTag(
			array(
				'tag' => 'optgroup',
				'attributes' => array(
					'label' => 'Warm',
				),
				'children' => array(
					'count' => 3
				)
			),
			$output
		);
		$this->assertTag(
			array(
				'tag' => 'option',
				'attributes' => array(
					'value' => 'red',
				),
				'content' => 'Red',
				'parent' => array(
					'tag' => 'optgroup',
				)
			),
			$output
		);
	}

	public function test_default_value() {
		/** @var WP_Form_Element_Select $element */
		$element = WP_Form_Element::create('select')->set_name('my-select');
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
			) )
			->set_default_value('green');
		$output = $element->render();

		error_log(print_r($output, TRUE));

		$this->assertTag(
			array(
				'tag' => 'option',
				'attributes' => array(
					'value' => 'green',
					'selected' => 'selected',
				),
				'content' => 'Green',
			),
			$output
		);

	}
}
