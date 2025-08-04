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
 * Provides methods to set the submit and cancel texts for a form.
 */
trait Submit {
	/** @var string|Translatable the text for the submit button */
	protected string|Translatable $submit = 'Yes';

	/** @var string|Translatable the text for the cancel button */
	protected string|Translatable $cancel = 'Cancel';

	/**
	 * Set the submit text.
	 *
	 * @param string|Translatable $submit the new submit text
	 */
	public function setSubmit(string|Translatable $submit) : static {
		$this->submit = $submit;
		return $this;
	}

	/**
	 * Set the cancel text.
	 *
	 * @param string|Translatable $cancel the new cancel text
	 */
	public function setCancel(string|Translatable $cancel) : static {
		$this->cancel = $cancel;
		return $this;
	}
}
