<?php

declare(strict_types=1);

namespace XanderID\PocketForm\simple;

use XanderID\PocketForm\PocketFormException;
use XanderID\PocketForm\PocketFormResponse;
use XanderID\PocketForm\simple\element\Button;
use function gettype;
use function is_int;

/**
 * Processes the response data from a simple form.
 */
class SimpleFormResponse extends PocketFormResponse {
	/** @var Button|null the button that was selected */
	private ?Button $selected = null;

	/**
	 * Process the raw response data.
	 *
	 * @param mixed $data the raw response data (expected to be an integer index)
	 *
	 * @throws PocketFormException if the response data is not an integer
	 */
	public function processData(mixed $data) : void {
		if (!is_int($data)) {
			throw new PocketFormException('Expected int got ' . gettype($data));
		}

		/** @var Button $selected */
		$selected = $this->form->getElement($data);
		$selected->setId($data);
		$this->selected = $selected;
	}

	/**
	 * Get the selected button element.
	 *
	 * @return Button the selected button
	 */
	public function getSelected() : Button {
		return $this->selected;
	}
}
