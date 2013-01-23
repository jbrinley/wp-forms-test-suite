<?php

class WP_Form_Element_Test extends WP_UnitTestCase {

	function test_basic_text_input() {
		$element = WP_Form_Element::create('text')->set_name('text-input');

		// We have the correct class
		$this->assertInstanceOf('WP_Form_Element', $element, 'Not a form element');
		$this->assertInstanceOf('WP_Form_Element_Text', $element, 'Not a text form element');

		$element->set_view( new WP_Form_View_Text() );
		$html = $element->render();

		// The output HTML is a text input
		$this->assertRegExp( '!<input.*type=["\']text["\'].*/>!', $html, 'Invalid text input HTML' );

		// The output HTML has the correct name
		$this->assertRegExp( '!name=["\']text-input["\']!', $html, 'Incorrect input name' );

	}
}
