<?php

/**
 * Class WP_Form_View_Fieldset_Test
 */
class WP_Form_View_Fieldset_Test extends WP_UnitTestCase {

	public function test_type_match() {
		$element = WP_Form_Element::create('fieldset');
		$fieldset_view = new WP_Form_View_Fieldset();

		$element->set_view($fieldset_view);
		$this->assertNotEmpty($element->render());
	}

	public function test_default_view() {
		$element = WP_Form_Element::create('fieldset');
		$view = $element->get_view();
		$this->assertInstanceOf('WP_Form_View_Fieldset', $view);
	}

	public function test_name() {
		$element = WP_Form_Element::create('fieldset')->set_name('fieldset-name');
		$output = $element->render();
		$this->assertTag(
			array(
				'tag' => 'fieldset',
				'attributes' => array(
					'name' => 'fieldset-name',
				)
			),
			$output
		);
	}

	public function test_legend() {
		$element = WP_Form_Element::create('fieldset');
		$element->set_label('The Legendary Fieldset');

		$output = $element->render();
		$this->assertTag(
			array(
				'tag' => 'legend',
				'content' => 'The Legendary Fieldset',
			),
			$output
		);
	}

	public function test_children() {
		$element = WP_Form_Element::create('fieldset')->set_name('fieldset-one');
		$child1 = WP_Form_Element::create('text')->set_name('child-one');
		$child2 = WP_Form_Element::create('text')->set_name('child-two');
		$element->add_element($child1)->add_element($child2);

		$output = $element->render();
		$this->assertTag(
			array(
				'tag' => 'input',
				'attributes' => array(
					'name' => 'child-one',
				)
			),
			$output
		);
		$this->assertTag(
			array(
				'tag' => 'input',
				'attributes' => array(
					'name' => 'child-two',
				)
			),
			$output
		);
	}
}
