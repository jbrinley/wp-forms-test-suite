<?php

class WP_Form_View_Button_Test extends WP_UnitTestCase {

	public function test_button() {
		$element = WP_Form_Element::create('button')
			->set_value('a button')
			->set_label('The button content');
		$element->set_view(new WP_Form_View_Button());

		$output = $element->render();
		$this->assertTag(
			array(
				'tag' => 'button',
				'attributes' => array(
					'type' => 'button',
					'value' => 'a button',
				),
				'content' => 'The button content',
			),
			$output
		);
	}
}
