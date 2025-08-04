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
use XanderID\PocketForm\utils\Translate;

/**
 * Represents an input field element.
 */
class Input extends CustomElement {
	/**
	 * @param string|Translatable      $label       the label for the input field
	 * @param string|Translatable      $placeholder the placeholder text for the input
	 * @param string|null              $default     the default value for the input (optional)
	 * @param string|Translatable|null $tooltip     tooltip shown on hover (optional)
	 */
	public function __construct(
		string|Translatable $label,
		protected string|Translatable $placeholder = '',
		protected ?string $default = null,
		null|string|Translatable $tooltip = null
	) {
		$this->setLabel($label);
		$this->setTooltip($tooltip);
	}

	/**
	 * Creates a new Input element.
	 *
	 * @param string|Translatable      $label       the label for the input field
	 * @param string|Translatable      $placeholder the placeholder text for the input
	 * @param string|null              $default     the default value for the input (optional)
	 * @param string|Translatable|null $tooltip     tooltip shown on hover (optional)
	 */
	public static function create(string|Translatable $label, string|Translatable $placeholder = '', ?string $default = null, null|string|Translatable $tooltip = null) : self {
		return new self($label, $placeholder, $default, $tooltip);
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
	 * @return string|Translatable the placeholder text
	 */
	public function getPlaceholder() : string|Translatable {
		return $this->placeholder;
	}

	/**
	 * Set the placeholder text.
	 *
	 * @param string|Translatable $placeholder the new placeholder text
	 */
	public function setPlaceholder(string|Translatable $placeholder) : self {
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
	 * @param float|int|string $default the default value
	 */
	public function setDefault(float|int|string $default) : self {
		$this->default = (string) $default;
		return $this;
	}

	/**
	 * Build the input element.
	 *
	 * @param array<string, list<array<string, mixed>>> &$components The components array to add the input to
	 */
	public function build(array &$components) : void {
		$input = [
			'type' => $this->getType(),
			'text' => Translate::translate($this->label),
			'placeholder' => Translate::translate($this->placeholder),
		];

		if ($this->default !== null) {
			$input['default'] = $this->default;
		}

		if ($this->tooltip !== null) {
			$input['tooltip'] = Translate::translate($this->tooltip);
		}

		$components['content'][] = $input;
	}
}
