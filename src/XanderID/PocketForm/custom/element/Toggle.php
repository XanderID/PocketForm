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

use XanderID\PocketForm\custom\CustomElement;

/**
 * Represents a toggle element for boolean values.
 */
class Toggle extends CustomElement {
	/**
	 * @param string    $label   the label for the toggle
	 * @param bool|null $default the default state (true for on, false for off)
	 */
	public function __construct(
		string $label,
		protected ?bool $default = null
	) {
		$this->setLabel($label);
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
	 * @param array<string, list<mixed>> &$components The components array to add the toggle to
	 */
	public function build(array &$components) : void {
		$toggle = ['type' => $this->getType(), 'text' => $this->label];
		if ($this->default !== null) {
			$toggle['default'] = $this->default;
		}

		$components['content'][] = $toggle;
	}
}
