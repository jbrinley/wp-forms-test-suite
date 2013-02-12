<?php

class WP_Form_View_Textarea_Test extends WP_UnitTestCase {
	public function test_type_match() {
		$element = WP_Form_Element::create('textarea')->set_name('green');
		$textarea_view = new WP_Form_View_Textarea();

		$element->set_view($textarea_view);
		$this->assertNotEmpty($element->render());
	}

	public function test_content() {
		$element = WP_Form_Element::create('textarea')->set_name('green');
		$element->set_value('Textarea content');
		$textarea_view = new WP_Form_View_Textarea();
		$element->set_view($textarea_view);

		$output = $element->render();
		$this->assertTag(
			array(
				'tag' => 'textarea',
				'content' => 'Textarea content',
				'attributes' => array(
					'name' => 'green',
					'rows' => 5,
					'cols' => 40,
				),
			),
			$output
		);
	}
}
