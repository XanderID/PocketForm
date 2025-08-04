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

namespace XanderID\PocketForm\traits;

use pocketmine\lang\Translatable;

/**
 * Provides methods to set and get the label of a form element.
 */
trait FormLabel {
	/** @var string|Translatable the form label */
	protected string|Translatable $label = '';

	/**
	 * Get the label.
	 *
	 * @return string|Translatable the current label
	 */
	public function getLabel() : string|Translatable {
		return $this->label;
	}

	/**
	 * Set the label.
	 *
	 * @param string|Translatable $label the new label
	 */
	public function setLabel(string|Translatable $label) : static {
		$this->label = $label;
		return $this;
	}
}
