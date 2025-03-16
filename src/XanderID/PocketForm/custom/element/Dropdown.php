<?php

declare(strict_types=1);

namespace XanderID\PocketForm\custom\element;

use XanderID\PocketForm\custom\CustomElement;
use XanderID\PocketForm\PocketFormException;
use XanderID\PocketForm\Utils;

/**
 * Represents a dropdown element with a list of options.
 */
class Dropdown extends CustomElement {
	/**
	 * @param string   $label   the label for the dropdown
	 * @param array    $options an array of options to display in the dropdown
	 * @param int|null $default the default selected index
	 */
	public function __construct(
		string $label,
		protected array $options,
		protected ?int $default = null
	) {
		$this->setLabel($label);
	}

	/**
	 * Get the element type.
	 *
	 * @return string returns "dropdown"
	 */
	public function getType() : string {
		return 'dropdown';
	}

	/**
	 * Get the dropdown options.
	 *
	 * @return array the list of options
	 */
	public function getOptions() : array {
		return $this->options;
	}

	/**
	 * Set the dropdown options.
	 *
	 * @param array $options the new list of options
	 */
	public function setOptions(array $options) : self {
		$this->options = $options;
		return $this;
	}

	/**
	 * Get the default index.
	 *
	 * @return int|null the default selected index
	 */
	public function getDefault() : ?int {
		return $this->default;
	}

	/**
	 * Set the default index.
	 *
	 * @param int $default the default index
	 */
	public function setDefault(int $default) : self {
		$this->default = $default;
		return $this;
	}

	/**
	 * Perform pre-build checks for the dropdown.
	 *
	 * @throws PocketFormException if options are not all strings or default index is invalid
	 */
	public function buildCheck() : void {
		if (Utils::validateArrayValueType($this->options, function (string $option) : void {})) {
			$this->buildError('Dropdown arrays can only be string');
		}

		$index = $this->default;
		if ($index !== null) {
			if (!isset($this->options[$index])) {
				$this->buildError('Cannot find Index ' . $index . ' on Dropdown');
			}
		}

		parent::buildCheck();
	}

	/**
	 * Build the dropdown element.
	 *
	 * @param array &$components The components array to add the dropdown to
	 */
	public function build(array &$components) : void {
		$dropdown = ['type' => $this->getType(), 'text' => $this->label, 'options' => $this->options];
		if ($this->default !== null) {
			$dropdown['default'] = $this->default;
		}

		$components['content'][] = $dropdown;
	}
}
