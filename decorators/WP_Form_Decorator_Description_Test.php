<?php

class WP_Form_Decorator_Description_Test extends WP_UnitTestCase {
	public function test_description() {
		$element = WP_Form_Element::create('text')
			->set_description( 'This is my description' )
			->set_view( new WP_Form_View_Text() )
			->add_decorator( 'WP_Form_Decorator_Description' );
		$output = $element->render();

		$this->assertRegExp('!<[^>]*>.*<p[^>]*>This is my description</p>$!', $output);
	}

	public function test_default_class() {
		$element = WP_Form_Element::create('text')
			->set_description( 'This is my description' )
			->set_view( new WP_Form_View_Text() )
			->add_decorator( 'WP_Form_Decorator_Description' );
		$output = $element->render();

		$this->assertRegExp('!<[^>]*>.*<p[^>]*class="description"[^>]*>This is my description</p>$!', $output);
	}

	public function test_class() {
		$element = WP_Form_Element::create('text')
			->set_description( 'This is my description' )
			->set_view( new WP_Form_View_Text() )
			->add_decorator( 'WP_Form_Decorator_Description', array( 'attributes' => array( 'class' => 'potato')) );
		$output = $element->render();

		$this->assertRegExp('!<[^>]*>.*<p[^>]*class="potato"[^>]*>This is my description</p>$!', $output);
	}

	public function test_tag() {
		$element = WP_Form_Element::create('text')
			->set_description( 'This is my description' )
			->set_view( new WP_Form_View_Text() )
			->add_decorator( 'WP_Form_Decorator_Description', array( 'tag' => 'span' ) );
		$output = $element->render();

		$this->assertRegExp('!<[^>]*>.*<span[^>]*>This is my description</span>$!', $output);
	}
}
