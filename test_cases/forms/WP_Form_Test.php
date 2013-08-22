<?php

class WP_Form_Test extends WP_UnitTestCase {
	public function test_get_element() {
		$form = new WP_Form( 'test-form' );
		$element = WP_Form_Element::create('text')->set_name('test-element');
		$form->add_element($element);

		$this->assertTrue( $element === $form->get_element( 'test-element' ) );
		$this->assertNull($form->get_element( 'another-element' ));
	}

	public function test_get_nested_element() {
		$form = new WP_Form( 'test-form' );
		$fieldset = WP_Form_Element::create('fieldset')->set_name('test-fieldset');
		$element = WP_Form_Element::create('text')->set_name('test-element');
		$fieldset->add_element($element);
		$form->add_element($fieldset);

		$this->assertTrue( $element === $form->get_element( 'test-element' ) );
	}

	public function test_get_doubly_nested_element() {
		$form = new WP_Form( 'test-form' );
		$fieldset1 = WP_Form_Element::create('fieldset')->set_name('test-fieldset1');
		$fieldset2 = WP_Form_Element::create('fieldset')->set_name('test-fieldset2');
		$element = WP_Form_Element::create('text')->set_name('test-element');
		$fieldset2->add_element($element);
		$fieldset1->add_element($fieldset2);
		$form->add_element($fieldset1);

		$this->assertTrue( $element === $form->get_element( 'test-element' ) );
	}

	public function test_accessors() {
		$form = new WP_Form( 'test-form' );
		$this->assertEquals( 'test-form', $form->id );
		$this->assertEquals( 'post', $form->method );
		$this->assertInstanceOf( 'WP_Form_View_Interface', $form->view );

		$form->view = new WP_Form_View_PartialForm();
		$this->assertInstanceOf( 'WP_Form_View_PartialForm', $form->view );

		$form->method = 'GET';
		$this->assertEquals( 'get', $form->method );
	}

	public function test_type() {
		$form = new WP_Form( 'test-form' );
		$this->assertEquals('form', $form->get_type());
	}

	public function test_add_nameless_element() {
		$form = new WP_Form( 'test-form' );
		$element = WP_Form_Element::create('text');

		$this->setExpectedException('InvalidArgumentException');
		$form->add_element($element);
	}

	public function test_named_nameless_element() {
		$form = new WP_Form( 'test-form' );
		$element = WP_Form_Element::create('text');

		$form->add_element($element, 'test-name');
	}

	public function test_nonce() {
		$form = new WP_Form( 'test-form' );
		$form->setup_nonce_fields();
		$id_element = $form->get_element('wp_form_id');
		$nonce_element = $form->get_element('wp_form_nonce');

		$this->assertNotNull($id_element);
		$this->assertEquals('wp_form_id', $id_element->get_name());
		$this->assertEquals('hidden', $id_element->get_type());

		$this->assertNotNull($nonce_element);
		$this->assertEquals('wp_form_nonce', $nonce_element->get_name());
		$this->assertEquals('hidden', $nonce_element->get_type());

		$this->assertNotEmpty(wp_verify_nonce($nonce_element->get_value(), $id_element->get_value()));
	}

	public function test_remove_element() {
		$form = new WP_Form( 'test-form' );
		$form->add_element(WP_Form_Element::create('text')->set_name('test-element'));
		$form->remove_element('test-element');

		$element = $form->get_element('test-element');
		$this->assertNull($element);
	}

	public function test_view() {
		$form = new WP_Form( 'test-form' );
		$view1 = $form->get_view();
		$this->assertInstanceOf('WP_Form_View_Form', $view1);

		$form->set_view(new WP_Form_View_Form());
		$view2 = $form->get_view();
		$this->assertFalse($view1 === $view2);
	}

	public function test_action() {
		$form = new WP_Form('test-form');
		$this->assertEmpty($form->get_action());

		$form->set_action('http://example.com');
		$this->assertEquals('http://example.com', $form->get_action());
	}

	public function test_method() {
		$form = new WP_Form('test-form');
		$this->assertEquals('post', $form->get_method());

		$form->set_method('get');
		$this->assertEquals('get', $form->get_method());

		$form->set_method('POST');
		$this->assertEquals('post', $form->get_method());

		$form->set_method('potato');
		$this->assertEquals('potato', $form->get_method());
	}

	public function test_attributes() {
		$form = new WP_Form('form-test');
		$form
			->set_attribute('enctype', 'application/x-www-form-urlencoded')
			->set_attribute('name', 'a-test-form')
			->set_attribute('id', 'form-test-id')
			->set_attribute('data-somethingRandom', 'this is random');

		$this->assertEquals('application/x-www-form-urlencoded', $form->get_attribute('enctype'));
		$this->assertEquals('a-test-form', $form->get_attribute('name'));
		$this->assertEquals('form-test-id', $form->get_attribute('id'));
		$this->assertEquals('this is random', $form->get_attribute('data-somethingRandom'));

		$this->assertEquals($form->get_attribute('id'), $form->get_id());
	}

	public function test_classes() {
		$form = new WP_Form('test-form');

		$this->assertEmpty($form->get_attribute('class'));

		$form->add_class('class1')->add_class('class2');
		$classes = $form->get_attribute('class');
		$this->assertTrue(strpos($classes, 'class1') !== FALSE);
		$this->assertTrue(strpos($classes, 'class2') !== FALSE);

		$form->set_attribute('class', 'red blue');
		$classes = $form->get_classes();
		$this->assertTrue(is_array($classes));
		$this->assertContains('red', $classes);
		$this->assertContains('blue', $classes);
		$this->assertNotContains('class1', $classes);
		$this->assertNotContains('class2', $classes);
	}

	public function test_id() {
		$form = new WP_Form('test-form');
		$this->assertEquals('test-form', $form->get_id());

		$form->set_attribute('id', 'potato');
		$this->assertEquals('potato', $form->get_id());
	}

	public function test_validators() {
		$form = new WP_Form('test-form');
		$form->add_validator('__return_true');
		$form->add_validator(array($this, 'imaginary_callback1'));
		$form->add_validator(array($this, 'imaginary_callback2'), 3);

		$validators = $form->get_validators();
		$this->assertEquals(3, count($validators));
		$this->assertEquals(array($this, 'imaginary_callback2'), $validators[0]);
		$this->assertEquals('__return_true', $validators[1]);
		$this->assertEquals(array($this, 'imaginary_callback1'), $validators[2]);

		// need correct priority to remove
		$form->remove_validator(array($this, 'imaginary_callback2'));
		$this->assertEquals(3, count($form->get_validators()));

		$form->remove_validator(array($this, 'imaginary_callback1'));
		$this->assertEquals(2, count($form->get_validators()));
	}
}
