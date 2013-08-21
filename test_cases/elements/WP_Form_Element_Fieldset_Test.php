<?php

/**
 * Class WP_Form_Element_Fieldset_Test
 */
class WP_Form_Element_Fieldset_Test extends WP_UnitTestCase {
	public function test_create() {
		$element = WP_Form_Element::create('fieldset');
		$this->assertInstanceOf('WP_Form_Element', $element);
		$this->assertInstanceOf('WP_Form_Aggregate', $element);
		$this->assertInstanceOf('WP_Form_Element_Fieldset', $element);
	}

	public function test_children() {
		$element = WP_Form_Element::create('fieldset');
		$child1 = WP_Form_Element::create('text')->set_name('username')->set_priority(10);
		$child2 = WP_Form_Element::create('password')->set_name('password')->set_priority(8);
		$element->add_element($child1);
		$element->add_element($child2);
		$this->assertEquals('username', $element->get_element('username')->get_name());
		$this->assertEquals('password', $element->get_element('password')->get_name());

		$children = $element->get_children();
		$this->assertCount(2, $children);
		$this->assertEquals('password', reset($children)->get_name());
	}

	public function test_not_children() {
		$element = WP_Form_Element::create('fieldset');
		$this->assertNull($element->get_element('username'));
	}

	public function test_remove_children() {
		$element = WP_Form_Element::create('fieldset');
		$child1 = WP_Form_Element::create('text')->set_name('username');
		$child2 = WP_Form_Element::create('password')->set_name('password');
		$element->add_element($child1);
		$element->add_element($child2);
		$element->remove_element('username');
		$this->assertNull($element->get_element('username'));
		$this->assertEquals('password', $element->get_element('password')->get_name());
		$element->remove_element('password');
		$this->assertNull($element->get_element('password'));
		$this->assertEmpty($element->get_children());
	}
}
