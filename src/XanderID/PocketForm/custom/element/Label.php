<?php

declare(strict_types=1);

namespace XanderID\PocketForm\custom\element;

use XanderID\PocketForm\custom\CustomElement;

/**
 * Represents a label element used to display static text.
 */
class Label extends CustomElement {
	/**
	 * @param string $label the text for the label element
	 */
	public function __construct(string $label) {
		$this->setLabel($label);
	}

	/**
	 * Get the element type.
	 *
	 * @return string returns "label"
	 */
	public function getType() : string {
		return 'label';
	}

	/**
	 * Build the label element.
	 *
	 * @param array &$components The components array to add the label to
	 */
	public function build(array &$components) : void {
		$label = ['type' => $this->getType(), 'text' => $this->label];
		$components['content'][] = $label;
	}
}
