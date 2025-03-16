<?php

declare(strict_types=1);

namespace XanderID\PocketForm\modal;

use XanderID\PocketForm\PocketFormException;
use XanderID\PocketForm\PocketFormResponse;
use function gettype;
use function is_bool;

/**
 * Processes the response data from a modal form.
 */
class ModalFormResponse extends PocketFormResponse {
	protected bool $choice;

	/**
	 * Process the raw response data.
	 *
	 * @param mixed $data the raw response data
	 *
	 * @throws PocketFormException if the response data is not a boolean
	 */
	public function processData(mixed $data) : void {
		if (!is_bool($data)) {
			throw new PocketFormException('Expected bool got ' . gettype($data));
		}

		$this->choice = $data;
	}

	public function getChoice() : bool {
		return $this->choice;
	}
}
