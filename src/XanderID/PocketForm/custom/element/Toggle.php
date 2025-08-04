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
 * Represents a toggle element for boolean values.
 */
class Toggle extends CustomElement {
	/**
	 * @param string|Translatable      $label   the label for the toggle
	 * @param bool|null                $default the default state (true for on, false for off) (optional)
	 * @param string|Translatable|null $tooltip tooltip shown on hover (optional)
	 */
	public function __construct(
		string|Translatable $label,
		protected ?bool $default = null,
		null|string|Translatable $tooltip = null
	) {
		$this->setLabel($label);
		$this->setTooltip($tooltip);
	}

	/**
	 * Creates a new Toggle element.
	 *
	 * @param string|Translatable      $label   the label for the toggle
	 * @param bool|null                $default the default state (true for on, false for off) (optional)
	 * @param string|Translatable|null $tooltip tooltip shown on hover (optional)
	 */
	public static function create(string|Translatable $label, ?bool $default = null, null|string|Translatable $tooltip = null) : self {
		return new self($label, $default, $tooltip);
	}

	/**
	 * Get the default toggle state.
	 *
	 * @return bool|null the default state
	 */
	public function getDefault() : ?bool {
		return $this->default;
	}

	/**
	 * Set the default toggle state.
	 *
	 * @param bool $default the default state
	 */
	public function setDefault(bool $default) : self {
		$this->default = $default;
		return $this;
	}

	/**
	 * Get the element type.
	 *
	 * @return string returns "toggle"
	 */
	public function getType() : string {
		return 'toggle';
	}

	/**
	 * Build the toggle element.
	 *
	 * @param array<string, list<array<string, mixed>>> &$components The components array to add the toggle to
	 */
	public function build(array &$components) : void {
		$toggle = [
			'type' => $this->getType(),
			'text' => Translate::translate($this->label),
		];

		if ($this->default !== null) {
			$toggle['default'] = $this->default;
		}

		if ($this->tooltip !== null) {
			$toggle['tooltip'] = Translate::translate($this->tooltip);
		}

		$components['content'][] = $toggle;
	}
}
