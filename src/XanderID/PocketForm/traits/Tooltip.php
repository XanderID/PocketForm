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
 * Provides methods to set and get tooltip text for UI elements.
 */
trait Tooltip {
	/** @var string|Translatable|null the tooltip text */
	protected null|string|Translatable $tooltip = null;

	/**
	 * Set the tooltip text.
	 *
	 * @param string|Translatable|null $tooltip the tooltip text to show on hover
	 */
	public function setTooltip(null|string|Translatable $tooltip) : static {
		$this->tooltip = $tooltip;
		return $this;
	}

	/**
	 * Get the tooltip text.
	 *
	 * @return string|Translatable|null the current tooltip text
	 */
	public function getTooltip() : null|string|Translatable {
		return $this->tooltip;
	}
}
