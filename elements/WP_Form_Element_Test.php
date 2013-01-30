<?php

/**
 * Tests applicable to generic form elements, of any subclass
 */
class WP_Form_Element_Test extends WP_UnitTestCase {

	public function test_create() {
		$element = WP_Form_Element::create('text');
		$this->assertInstanceOf('WP_Form_Element', $element);
		$this->assertInstanceOf('WP_Form_Element_Text', $element);

		// fall back to text if type doesn't have a class
		$element = WP_Form_Element::create('not_an_element_type');
		$this->assertInstanceOf('WP_Form_Element', $element);
		$this->assertNotInstanceOf('WP_Form_Element_Submit', $element);

		// can't change type on an existing element
		$this->setExpectedException('InvalidArgumentException');
		$element->type = 'hidden';
	}

	public function test_name() {
		$element = WP_Form_Element::create('text');
		$element->set_name('test_set_name');
		$this->assertEquals('test_set_name', $element->get_name());

		// test magic setter/getter
		$element->name = 'test_set_name2';
		$this->assertEquals('test_set_name2', $element->get_name());
		$this->assertEquals('test_set_name2', $element->name);
	}

	public function test_type() {
		$element = WP_Form_Element::create('text');
		$this->assertEquals('text', $element->get_type());
		$this->assertEquals('text', $element->type);

		// fall back to text if type doesn't have a class
		$element = WP_Form_Element::create('not_an_element_type');
		$this->assertEquals('text', $element->get_type());

		// can't change type on an existing element
		$this->setExpectedException('InvalidArgumentException');
		$element->type = 'hidden';
	}

	public function test_default_value() {
		$element = WP_Form_Element::create('text');
		$element->set_default_value('test_default_value');
		$this->assertEquals('test_default_value', $element->get_default_value());
		$this->assertEquals('test_default_value', $element->default_value);
	}

	public function test_value() {
		$element = WP_Form_Element::create('text');
		$element->set_value('test_value');
		$this->assertEquals('test_value', $element->get_value());
		$this->assertEquals('test_value', $element->value);
	}

	public function test_priority() {
		$element = WP_Form_Element::create('text');
		$this->assertEquals(10, $element->get_priority());

		$element->priority = 12;
		$this->assertEquals(12, $element->get_priority());
		$this->assertEquals(12, $element->priority);

		$element->set_priority(0);
		$this->assertEquals(0, $element->get_priority());

		$element->set_priority(-1);
		$this->assertEquals(-1, $element->get_priority());

		$element->set_priority('test_priority');
		$this->assertEquals(0, $element->get_priority());

		$element->set_priority(TRUE);
		$this->assertEquals(1, $element->get_priority());

		$element->set_priority(FALSE);
		$this->assertEquals(0, $element->get_priority());
	}

	public function test_label() {
		$element = WP_Form_Element::create('text');
		$element->set_label('test_label');
		$this->assertEquals('test_label', $element->get_label());
		$this->assertEquals('test_label', $element->label);
	}

	public function test_description() {
		$element = WP_Form_Element::create('text');
		$this->assertEquals('', $element->get_description());
		$element->set_description('test_description');
		$this->assertEquals('test_description', $element->get_description());
		$this->assertEquals('test_description', $element->description);
	}

	public function test_view() {
		$element = WP_Form_Element::create('text');
		$default_decorators = $element->get_default_decorators();
		end($default_decorators);
		$decorator = key($default_decorators);

		$this->assertInstanceOf('WP_Form_View_Interface', $element->get_view());
		$this->assertInstanceOf($decorator, $element->get_view());

		$element->set_view( new WP_Form_View_Text() );
		$this->assertInstanceOf('WP_Form_View_Text', $element->get_view());
	}

	public function test_sort() {
		$element1 = WP_Form_Element::create('text')->set_priority(5);
		$element2 = WP_Form_Element::create('text')->set_priority(2);
		$element3 = WP_Form_Element::create('text')->set_priority(10);
		$element4 = WP_Form_Element::create('text');
		$element5 = WP_Form_Element::create('text')->set_priority(-3);
		$element6 = WP_Form_Element::create('text')->set_priority(10);

		$elements = array($element1, $element2, $element3, $element4, $element5, $element6);
		$elements = WP_Form_Element::sort_elements($elements);
		$elements = array_values($elements);
		$this->assertTrue($element5 === $elements[0]);
		$this->assertTrue($element2 === $elements[1]);
		$this->assertTrue($element1 === $elements[2]);
		$this->assertTrue($element3 === $elements[3]);
		$this->assertTrue($element4 === $elements[4]);
		$this->assertTrue($element6 === $elements[5]);
	}

	public function test_attributes() {
		$element = WP_Form_Element::create('text');
		$element->set_name('test-element')
			->set_default_value('potato')
			->set_attribute('id', 'test-element-id')
			->set_attribute('placeholder', $element->get_default_value())
			->set_attribute('class', 'blue green');

		$this->assertEquals('test-element-id', $element->get_id());
		$this->assertEquals('test-element-id', $element->get_attribute('id'));
		$this->assertEquals('potato', $element->get_attribute('placeholder'));
		$this->assertTrue(is_array($element->get_classes()));
		$this->assertContains('blue', $element->get_classes());
		$this->assertContains('green', $element->get_classes());

		$element->add_class('yellow');
		$this->assertContains('yellow', $element->get_classes());
		$this->assertContains('blue', $element->get_classes());
		$this->assertContains('green', $element->get_classes());

		$element->remove_class('blue');
		$this->assertNotContains('blue', $element->get_classes());
	}

	public function test_set_type_attribute() {
		$element = WP_Form_Element::create('text');
		$this->setExpectedException('InvalidArgumentException');
		$element->set_attribute('type', 'hidden');
	}

	public function test_set_value_attribute() {
		$element = WP_Form_Element::create('text');
		$this->setExpectedException('InvalidArgumentException');
		$element->set_attribute('value', 'potato');
	}
}
