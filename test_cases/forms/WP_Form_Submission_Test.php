<?php

class WP_Form_Submission_Test extends WP_UnitTestCase {
	private $submitted_value = 0;

	public function test_create() {
		$form = new WP_Form('test-form');
		$data = array();
		$submission = new WP_Form_Submission($form, $data);
		$this->assertInstanceOf('WP_Form_Submission', $submission);
	}

	public function test_validate() {
		$form = new WP_Form('test-form');
		$form->add_validator(array($this, '_validate_is_twelve'));

		$good = array('test' => 12);
		$good_submission = new WP_Form_Submission( $form, $good );
		$this->assertTrue($good_submission->is_valid());

		$bad = array('test' => 11);
		$bad_submission = new WP_Form_Submission( $form, $bad );
		$this->assertFalse($bad_submission->is_valid());
	}

	public function _validate_is_twelve( WP_Form_Submission $submission, WP_Form $form ) {
		if ( $submission->get_value('test') != 12 ) {
			$submission->add_error('test', 'test is not 12');
		}
	}

	public function test_submit() {
		$form = new WP_form('test-form');
		$form->add_processor(array($this, '_save_test_submit'));
		$data = array( 'test' => 12, 'potato' => array( 'red' => 2, 'yellow' => 4 ) );
		$submission = new WP_Form_Submission( $form, $data );
		$submission->submit();
	}

	public function _save_test_submit( WP_Form_Submission $submission, WP_Form $form ) {
		$this->assertEquals(12, $submission->get_value('test'));
		$this->assertTrue(is_array($submission->get_value('potato')));
		$this->assertEquals(2, $submission->get_value('potato[red]'));
		$this->assertEquals(4, $submission->get_value('potato[yellow]'));

	}

	public function test_submission_redirect() {
		$form = new WP_form('test-form');
		$form->set_redirect('http://example.org');
		$submission = new WP_Form_Submission( $form, array() );
		$this->assertEquals('http://example.org', $submission->get_redirect());
		$submission->set_redirect(NULL);
		$this->assertEquals(NULL, $submission->get_redirect());
		$submission->set_redirect();
		$this->assertEquals('http://example.org', $submission->get_redirect());
		$submission->set_redirect('http://example.com');
		$this->assertEquals('http://example.com', $submission->get_redirect());
	}

	public function test_prepare_form() {
		$form = new WP_form('test-form');
		$form->add_element(WP_Form_Element::create('text')->set_name('test')->set_default_value(5));
		$form->add_element(WP_Form_Element::create('text')->set_name('potato[red]'));
		$form->add_element(WP_Form_Element::create('text')->set_name('potato[yellow]'), 'yellowpotato');
		$form->add_validator(array($this, '_validate_test_prepare_form'));

		$data = array( 'test' => 12, 'potato' => array( 'red' => 2, 'yellow' => 4 ) );
		$submission = new WP_Form_Submission( $form, $data );
		if ( !$submission->is_valid() ) {
			$submission->prepare_form();
		}

		$this->assertEquals(12, $form->get_element('test')->get_value());
		$this->assertEquals(array('Error on test'), $form->get_element('test')->get_errors());
		$this->assertEquals(2, $form->get_element('potato[red]')->get_value());
		$this->assertEquals(array('Red potato error'), $form->get_element('potato[red]')->get_errors());
		$this->assertEquals(4, $form->get_element('yellowpotato')->get_value());
		$this->assertEquals(array('Yellow potato error'), $form->get_element('yellowpotato')->get_errors());
		$this->assertEquals(array('Top-level form error'), $form->get_errors());
	}

	public function _validate_test_prepare_form( WP_Form_Submission $submission, WP_Form $form ) {
		$submission->add_error('test-form', 'Top-level form error');
		$submission->add_error('test', 'Error on test');
		$submission->add_error('potato[red]', 'Red potato error');
		$submission->add_error('potato[yellow]', 'Yellow potato error');
	}

	public function test_slashes() {
		$form = new WP_form('test-form');
		$form->add_processor(array($this, '_save_test_slashes'));
		$data = array(
			'no_slash' => addslashes("I haven't got a potato"),
			'slashed' => addslashes("But I've certainly got a backslash (\\).")
		);
		$submission = new WP_Form_Submission( $form, $data );
		$submission->submit();
	}

	public function _save_test_slashes( WP_Form_Submission $submission, WP_Form $form ) {
		$this->assertEquals("I haven't got a potato", $submission->get_value('no_slash'));
		$this->assertEquals("But I've certainly got a backslash (\\).", $submission->get_value('slashed'));
	}
}
