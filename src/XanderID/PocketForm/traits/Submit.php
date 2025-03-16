<?php

declare(strict_types=1);

namespace XanderID\PocketForm\traits;

/**
 * Provides methods to set the submit and cancel texts for a form.
 */
trait Submit {
	/** @var string the text for the submit button */
	protected string $submit = 'Yes';

	/** @var string the text for the cancel button */
	protected string $cancel = 'Cancel';

	/**
	 * Set the submit text.
	 *
	 * @param string $submit the new submit text
	 */
	public function setSubmit(string $submit) : self {
		$this->submit = $submit;
		return $this;
	}

	/**
	 * Set the cancel text.
	 *
	 * @param string $cancel the new cancel text
	 */
	public function setCancel(string $cancel) : self {
		$this->cancel = $cancel;
		return $this;
	}
}
