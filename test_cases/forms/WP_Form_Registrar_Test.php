<?php

/**
 * Class WP_Form_Registrar_Test
 */
class WP_Form_Registrar_Test extends WP_UnitTestCase {
	/** @var WP_Form_Registrar */
	private $registrar;

	public function setUp() {
		parent::setUp();
		$this->registrar = WP_Form_Registrar::get_instance();
	}

	public function tearDown() {
		parent::tearDown();
		WP_Form_Registrar::reinit();
	}

	public function test_registration() {
		$this->registrar->register( 'test-form-one', array( $this, '_test_form_one_callback' ) );
		$form = $this->registrar->get_form( 'test-form-one' );
		$this->assertInstanceOf('WP_Form', $form);
		$this->assertEquals( 'first_name', $form->get_element('first_name')->get_name() );
	}

	public function test_deregistration() {
		$this->registrar->register( 'test-form-one', array( $this, '_test_form_one_callback' ) );
		$this->registrar->deregister( 'test-form-one' );
		$this->setExpectedException('InvalidArgumentException');
		$this->registrar->get_form( 'test-form-one' );
	}

	public function test_invalid_form() {
		$this->setExpectedException('InvalidArgumentException');
		$this->registrar->get_form( 'test-form-one' );
	}

	public function test_invalid_callback() {
		$this->registrar->register( 'test-form-blue', array( $this, '_test_form_blue_callback' ) );
		$this->setExpectedException('BadFunctionCallException');
		$this->registrar->get_form( 'test-form-blue' );
	}

	public function _test_form_one_callback( WP_Form $form ) {
		$form
			->add_element(
				WP_Form_Element::create('text')
					->set_name('first_name')
					->set_label('First Name')
			)
			->add_element(
				WP_form_Element::create('text')
					->set_name('last_name')
					->set_label('Last Name')
			);
	}
}
