<?php

declare(strict_types=1);

namespace XanderID\PocketForm\custom\element;

use XanderID\PocketForm\custom\CustomElement;

/**
 * Represents an input field element.
 */
class Input extends CustomElement {
	/**
	 * @param string      $label       the label for the input field
	 * @param string      $placeholder the placeholder text for the input
	 * @param string|null $default     the default value for the input
	 */
	public function __construct(
		string $label,
		protected string $placeholder = '',
		protected ?string $default = null
	) {
		$this->setLabel($label);
	}

	/**
	 * Get the element type.
	 *
	 * @return string returns "input"
	 */
	public function getType() : string {
		return 'input';
	}

	/**
	 * Get the placeholder text.
	 *
	 * @return string the placeholder text
	 */
	public function getPlaceholder() : string {
		return $this->placeholder;
	}

	/**
	 * Set the placeholder text.
	 *
	 * @param string $placeholder the new placeholder text
	 */
	public function setPlaceholder(string $placeholder) : self {
		$this->placeholder = $placeholder;
		return $this;
	}

	/**
	 * Get the default value.
	 *
	 * @return string|null the default value
	 */
	public function getDefault() : ?string {
		return $this->default;
	}

	/**
	 * Set the default value.
	 *
	 * @param string $default the default value
	 */
	public function setDefault(string $default) : self {
		$this->default = $default;
		return $this;
	}

	/**
	 * Build the input element.
	 *
	 * @param array &$components The components array to add the input to
	 */
	public function build(array &$components) : void {
		$input = ['type' => $this->getType(), 'text' => $this->label, 'placeholder' => $this->placeholder, 'tip' => 'kont'];
		if ($this->default !== null) {
			$input['default'] = $this->default;
		}

		$components['content'][] = $input;
	}
}
