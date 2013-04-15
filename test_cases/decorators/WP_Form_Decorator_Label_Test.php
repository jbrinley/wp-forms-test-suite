<?php

class WP_Form_Decorator_Label_Test extends WP_UnitTestCase {
	public function test_label() {
		$element = WP_Form_Element::create('text')
			->set_label( 'This is my label' )
			->set_view( new WP_Form_View_Input() )
			->add_decorator( 'WP_Form_Decorator_Label' );
		$output = $element->render();

		$this->assertRegExp('!^<label[^>]*>This is my label</label>.*<[^>]*>!', $output);
	}

	public function test_class() {
		$element = WP_Form_Element::create('text')
			->set_label( 'This is my label' )
			->set_view( new WP_Form_View_Input() )
			->add_decorator( 'WP_Form_Decorator_Label' );
		$output = $element->render();

		$this->assertRegExp('!<label[^>]*class="form-label"[^>]*>!', $output);
	}

	public function test_for() {
		$element = WP_Form_Element::create('text')
			->set_label( 'This is my label' )
			->set_view( new WP_Form_View_Input() )
			->add_decorator( 'WP_Form_Decorator_Label' )
			->set_attribute('id', 'my-form-element');
		$output = $element->render();

		$this->assertRegExp('!<label[^>]*for="my-form-element"[^>]*>!', $output);
	}
}
