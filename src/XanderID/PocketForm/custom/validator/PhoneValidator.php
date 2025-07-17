<?php

declare(strict_types=1);

namespace XanderID\PocketForm\custom\validator;

use InvalidArgumentException;
use XanderID\PocketForm\utils\CountryPhones;
use function gettype;
use function is_scalar;

/**
 * Validates international phone numbers using country codes from CountryPhones.
 *
 * This validator checks if the phone number:
 * - Starts with or without a plus sign (+), based on configuration
 * - Matches a valid country code (optionally)
 * - Has a valid length and numeric content
 *
 * Example:
 * ```php
 * $validator = PhoneValidator::create(true, true);
 * $input->validator($validator);
 * ```
 */
class PhoneValidator extends Validator {
	/**
	 * Whether the phone number must start with a '+'.
	 */
	protected bool $requirePlusSign;

	/**
	 * Whether to validate country code against known codes from the JSON file.
	 */
	protected bool $validateCountryCode;

	/**
	 * PhoneValidator constructor.
	 *
	 * @param bool   $requirePlusSign     Whether the phone number must start with '+' (default: true)
	 * @param bool   $validateCountryCode Whether to restrict to known country codes (default: true)
	 * @param string $error               Error message to return on validation failure
	 */
	public function __construct(
		bool $requirePlusSign = true,
		bool $validateCountryCode = true,
		string $error = 'Please enter a valid phone number.'
	) {
		$this->requirePlusSign = $requirePlusSign;
		$this->validateCountryCode = $validateCountryCode;
		parent::__construct('PhoneValidator', $error);
	}

	/**
	 * Create a new instance of PhoneValidator.
	 *
	 * @param bool   $requirePlusSign     Whether the phone number must start with '+'
	 * @param bool   $validateCountryCode Whether to restrict to known country codes
	 * @param string $error               Error message to return on validation failure
	 */
	public static function create(
		bool $requirePlusSign = true,
		bool $validateCountryCode = true,
		string $error = 'Please enter a valid phone number.'
	) : self {
		return new self($requirePlusSign, $validateCountryCode, $error);
	}

	/**
	 * Validate the phone number.
	 *
	 * @param mixed $data The value to validate (should be a string or scalar)
	 *
	 * @return string|null Returns the error message if invalid, or null if valid
	 *
	 * @throws InvalidArgumentException If non-scalar data is passed
	 */
	public function validate(mixed $data) : ?string {
		if (!is_scalar($data)) {
			throw new InvalidArgumentException('Expected scalar value to validate, got ' . gettype($data));
		}

		$phone = (string) $data;
		$result = CountryPhones::getInstance()->validatePhone(
			$phone,
			$this->requirePlusSign,
			$this->validateCountryCode
		);

		return $result === null ? $this->error() : null;
	}
}
