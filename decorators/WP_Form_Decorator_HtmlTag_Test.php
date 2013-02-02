<?php

class WP_Form_Decorator_HtmlTag_Test extends WP_UnitTestCase {
	public function test_defaults() {
		$element = WP_Form_Element::create('text')
			->set_view( new WP_Form_View_Text() )
			->add_decorator( 'WP_Form_Decorator_HtmlTag' );
		$output = $element->render();

		$this->assertRegExp('!^<div[^>]*>.*<[^>]*>.*</div>!', $output);
	}

	public function test_tag() {
		$element = WP_Form_Element::create('text')
			->set_view( new WP_Form_View_Text() )
			->add_decorator( 'WP_Form_Decorator_HtmlTag', array( 'tag' => 'p' ) );
		$output = $element->render();

		$this->assertRegExp('!^<p[^>]*>.*<[^>]*>.*</p>!', $output);
	}

	public function test_attributes() {
		$element = WP_Form_Element::create('text')
			->set_view( new WP_Form_View_Text() )
			->add_decorator( 'WP_Form_Decorator_HtmlTag', array(
					'attributes' => array(
						'class' => 'form-element-wrapper'
					)
				)
			);
		$output = $element->render();

		$this->assertRegExp('!^<div[^>]*class="form-element-wrapper"[^>]*>.*<[^>]*>.*</div>!', $output);
	}
}
