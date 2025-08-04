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
 * Provides methods to set and get the body content for simple and modal forms.
 */
trait Body {
	/** @var string|Translatable the body content */
	protected string|Translatable $body = '';

	/**
	 * Set the body content.
	 *
	 * @param string|Translatable $body the content to set
	 */
	public function setBody(string|Translatable $body) : static {
		$this->body = $body;
		return $this;
	}

	/**
	 * Get the body content.
	 *
	 * @return string|Translatable the current body content
	 */
	public function getBody() : string|Translatable {
		return $this->body;
	}
}
