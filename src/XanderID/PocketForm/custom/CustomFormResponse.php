<?php

declare(strict_types=1);

namespace XanderID\PocketForm\custom;

use XanderID\PocketForm\PocketFormException;
use XanderID\PocketForm\PocketFormResponse;
use function gettype;
use function is_array;

/**
 * Processes the response data from a custom form.
 */
class CustomFormResponse extends PocketFormResponse {
	/** @var array processed response data */
	protected array $response = [];

	/**
	 * Process the raw response data.
	 *
	 * @param mixed $data the raw response data
	 *
	 * @throws PocketFormException if the data is not an array
	 */
	public function processData(mixed $data) : void {
		if (!is_array($data)) {
			throw new PocketFormException('Expected array got ' . gettype($data));
		}

		$this->response = $data;
	}

	/**
	 * Get the processed response values.
	 *
	 * @return array the processed response data
	 */
	public function getValues() : array {
		return $this->response;
	}
}
