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

	public function _validate_is_twelve( array $data, WP_Error $errors, WP_Form $form ) {
		if ( $data['test'] != 12 ) {
			$errors->add('test', 'test is not 12');
		}
	}

	public function test_submit() {
		$form = new WP_form('test-form');
		$form->add_processor(array($this, '_save_test_form'));
		$data = array('test' => 12);
		$submission = new WP_Form_Submission( $form, $data );
		$submission->submit();
		$this->assertEquals(12, $this->submitted_value);
	}

	public function _save_test_form( array $data, WP_Form $form ) {
		$this->submitted_value = $data['test'];
	}
}
