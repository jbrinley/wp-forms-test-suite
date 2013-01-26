<?php

class WP_Form_Decorator_Test extends WP_UnitTestCase {
	public function test_decoration() {
		$element = WP_Form_Element::create('text');
		$element->set_view( new WP_Form_View_Text() );
		$element->add_decorator( 'WP_Form_Decorator_Label' );

		$this->assertInstanceOf( 'WP_Form_View_Interface', $element->get_view() );
		$this->assertInstanceOf( 'WP_Form_Decorator_Label', $element->get_view() );
	}
}
