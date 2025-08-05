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

/**
 * Provides methods to set and get the closeable status of a form.
 */
trait FormCloseable {
	/** @var bool whether the form can be closed (default: true) */
	protected bool $closeable = true;

	/**
	 * Determine if the form is closeable.
	 *
	 * @return bool true if the form can be closed, false otherwise
	 */
	public function isCloseable() : bool {
		return $this->closeable;
	}

	/**
	 * Set whether the form can be closed.
	 *
	 * @param bool $closeable true to allow closing the form, false to prevent it
	 *
	 * @return $this
	 */
	public function setCloseable(bool $closeable) : static {
		$this->closeable = $closeable;
		return $this;
	}
}
