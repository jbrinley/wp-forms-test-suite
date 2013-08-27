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

	public function test_arguments() {
		$this->registrar->register( 'test-form-two', array( $this, '_test_form_two_callback' ) );
		$form = $this->registrar->get_form( 'test-form-two', 'Given Name', 'Family Name' );
		$this->assertEquals( 'Given Name', $form->get_element('first_name')->get_label() );
		$this->assertEquals( 'Family Name', $form->get_element('last_name')->get_label() );
	}

	public function test_varying_arguments() {
		$this->registrar->register( 'test-form-two', array( $this, '_test_form_two_callback' ) );

		$form = $this->registrar->get_form( 'test-form-two', 'Given Name', 'Family Name' );
		$this->assertEquals( 'Given Name', $form->get_element('first_name')->get_label() );
		$this->assertEquals( 'Family Name', $form->get_element('last_name')->get_label() );

		$form = $this->registrar->get_form( 'test-form-two', 'Name One', 'Name Two' );
		$this->assertEquals( 'Name One', $form->get_element('first_name')->get_label() );
		$this->assertEquals( 'Name Two', $form->get_element('last_name')->get_label() );
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

	public function _test_form_two_callback( WP_Form $form, $first_name_label = "First Name", $last_name_lael = "Last Name" ) {
		$form
			->add_element(
				WP_Form_Element::create('text')
					->set_name('first_name')
					->set_label($first_name_label)
			)
			->add_element(
				WP_form_Element::create('text')
					->set_name('last_name')
					->set_label($last_name_lael)
			);
	}
}
