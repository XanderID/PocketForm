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

namespace XanderID\PocketForm\custom\validator;

use function gettype;
use function is_scalar;
use function preg_match;

/**
 * A validator that checks if the input data matches a specified regular expression pattern.
 *
 * Example usage:
 * ```php
 * $email = new Input('Email', 'user@example.com');
 * $email->validator(RegexValidator::EMAIL());
 *
 * // Or for a custom pattern:
 * $validator = RegexValidator::create('/^[A-Z]+$/', 'Only uppercase letters are allowed.');
 * $input->validator($validator);
 * ```
 */
class RegexValidator extends Validator {
	/**
	 * @param string $pattern the regular expression pattern to validate against
	 * @param string $error   the error message to return if validation fails
	 */
	public function __construct(
		string $pattern,
		string $error = Validator::DEFAULT_ERROR
	) {
		parent::__construct($pattern, $error);
	}

	/**
	 * Creates a new RegexValidator instance.
	 *
	 * @param string $pattern the regular expression pattern to validate against
	 * @param string $error   the error message to return if validation fails
	 *
	 * @return self returns a new instance of RegexValidator
	 */
	public static function create(string $pattern, string $error = Validator::DEFAULT_ERROR) : self {
		return new self($pattern, $error);
	}

	/**
	 * Validate the given data against the regular expression pattern.
	 *
	 * @param mixed $data the data to validate
	 *
	 * @return string|null returns an error message if validation fails, or null if valid
	 *
	 * @throws \InvalidArgumentException if the data is not a scalar value
	 */
	public function validate(mixed $data) : ?string {
		if (!is_scalar($data)) {
			throw new \InvalidArgumentException('Expected scalar value to validate, got ' . gettype($data));
		}

		/** @var string $pattern */
		$pattern = $this->validator;
		return !preg_match($pattern, (string) $data) ? $this->error() : null;
	}

	/**
	 * Create an email validator.
	 *
	 * @param string $error the error message for invalid email addresses
	 *
	 * @return self returns a new instance of RegexValidator for email validation
	 */
	public static function EMAIL(string $error = 'Please enter a valid email address.') : self {
		$emailPattern = '/^[\w\.\-]+@([\w\-]+\.)+[a-zA-Z]{2,7}$/';
		return new self($emailPattern, $error);
	}

	/**
	 * Create a UUID validator.
	 *
	 * @param string $error the error message for invalid UUIDs
	 */
	public static function UUID(string $error = 'Please enter a valid UUID.') : self {
		$uuidPattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';
		return new self($uuidPattern, $error);
	}

	/**
	 * Create a URL validator.
	 *
	 * @param string $error the error message for invalid URLs
	 */
	public static function URL(string $error = 'Please enter a valid URL.') : self {
		$urlPattern = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([/\w\.-]*)*\/?$/i';
		return new self($urlPattern, $error);
	}
}
