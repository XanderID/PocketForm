<?php

/*
 * Copyright (c) 2025-2025 XanderID
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/XanderID/PocketForm
 */

declare(strict_types=1);

namespace XanderID\PocketForm\custom\element;

use pocketmine\lang\Translatable;
use XanderID\PocketForm\custom\CustomElement;
use XanderID\PocketForm\PocketFormException;
use XanderID\PocketForm\Utils;
use XanderID\PocketForm\utils\Translate;
use function array_map;

/**
 * Represents a dropdown element with a list of options.
 */
class Dropdown extends CustomElement {
	/**
	 * @param string|Translatable       $label   the label for the dropdown
	 * @param list<string|Translatable> $options an array of options to display in the dropdown
	 * @param int|null                  $default the default selected index (optional)
	 * @param string|Translatable|null  $tooltip tooltip shown on hover (optional)
	 */
	public function __construct(
		string|Translatable $label,
		protected array $options,
		protected ?int $default = null,
		null|string|Translatable $tooltip = null
	) {
		$this->setLabel($label);
		$this->setTooltip($tooltip);
	}

	/**
	 * Creates a new Dropdown element.
	 *
	 * @param list<string|Translatable> $options
	 */
	public static function create(string|Translatable $label, array $options, ?int $default = null, null|string|Translatable $tooltip = null) : self {
		return new self($label, $options, $default, $tooltip);
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
	 * @return list<string|Translatable> the list of options
	 */
	public function getOptions() : array {
		return $this->options;
	}

	/**
	 * Set the dropdown options.
	 *
	 * @param list<string|Translatable> $options
	 */
	public function setOptions(array $options) : self {
		$this->options = $options;
		return $this;
	}

	/**
	 * Get the default index.
	 */
	public function getDefault() : ?int {
		return $this->default;
	}

	/**
	 * Set the default index.
	 */
	public function setDefault(int $default) : self {
		$this->default = $default;
		return $this;
	}

	/**
	 * Perform pre-build checks for the dropdown.
	 *
	 * @throws PocketFormException
	 */
	public function buildCheck() : void {
		if (Utils::validateArrayValueType($this->options, function (string|Translatable $option) : void {})) {
			$this->buildError('Dropdown options must be string or Translatable');
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
	 * @param array<string, list<array<string, mixed>>> &$components
	 */
	public function build(array &$components) : void {
		$translatedLabel = Translate::translate($this->label);
		$translatedTooltip = $this->tooltip !== null ? Translate::translate($this->tooltip) : null;

		$translatedOptions = array_map(
			fn ($opt) => Translate::translate($opt),
			$this->options
		);

		$dropdown = [
			'type' => $this->getType(),
			'text' => $translatedLabel,
			'options' => $translatedOptions,
		];

		if ($this->default !== null) {
			$dropdown['default'] = $this->default;
		}

		if ($translatedTooltip !== null) {
			$dropdown['tooltip'] = $translatedTooltip;
		}

		$components['content'][] = $dropdown;
	}
}
