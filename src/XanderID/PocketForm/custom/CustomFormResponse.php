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

namespace XanderID\PocketForm\custom;

use XanderID\PocketForm\PocketFormException;
use XanderID\PocketForm\PocketFormResponse;
use XanderID\PocketForm\Utils;
use function array_values;
use function gettype;
use function is_array;

/**
 * Processes the response data from a custom form.
 *
 * @extends PocketFormResponse<CustomForm>
 *
 * @phpstan-type NonFloatScalar string|int|bool
 */
class CustomFormResponse extends PocketFormResponse {
	/** @var list<NonFloatScalar> processed response data */
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

		$data = array_values($data);
		if (Utils::validateArrayValueType($data, function (bool|int|string $data) : void {})) {
			throw new PocketFormException('Invalid response data: all elements must be bool, int, or string.');
		}

		/** @var list<bool|int|string> $data */
		$this->response = $data;
	}

	/**
	 * Get the processed response values.
	 *
	 * @return list<NonFloatScalar> the processed response data
	 */
	public function getValues() : array {
		return $this->response;
	}
}
