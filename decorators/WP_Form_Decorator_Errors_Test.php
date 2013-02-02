<?php

class WP_Form_Decorator_Errors_Test extends WP_UnitTestCase {
	public function test_error() {
		$element = WP_Form_Element::create('text')
			->set_view( new WP_Form_View_Text() )
			->add_decorator( 'WP_Form_Decorator_Errors' )
			->set_error('Explode!');
		$output = $element->render();

		$this->assertTag( array(
			'tag' => 'li',
			'ancestor' => array( 'tag' => 'ul' ),
			'content' => 'Explode!',
		), $output);
		$this->assertTag( array(
			'tag' => 'input',
		), $output);
		$this->assertRegExp('!<ul.*<input!', $output);
	}
	public function test_multiple_errors() {
		$element = WP_Form_Element::create('text')
			->set_view( new WP_Form_View_Text() )
			->add_decorator( 'WP_Form_Decorator_Errors' )
			->set_error('Explode!')
			->set_error('Kaboom!');
		$output = $element->render();

		$this->assertTag( array(
			'tag' => 'li',
			'ancestor' => array( 'tag' => 'ul' ),
			'content' => 'Explode!',
		), $output);
		$this->assertTag( array(
			'tag' => 'li',
			'ancestor' => array( 'tag' => 'ul' ),
			'content' => 'Kaboom!',
		), $output);
		$this->assertTag( array(
			'tag' => 'ul',
			'attributes' => array( 'class' => 'errors' ),
			'children' => array( 'count' => 2 ),
		), $output);
	}
}
