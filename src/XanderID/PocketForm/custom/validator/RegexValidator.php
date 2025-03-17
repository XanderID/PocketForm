<?php

declare(strict_types=1);

namespace XanderID\PocketForm\custom\validator;

use function preg_match;

/**
 * A validator that checks if the input data matches a specified regular expression pattern.
 *
 * Example usage:
 * ```
 * $email = new Input('Email', 'user@example.com');
 * $email->validator(RegexValidator::EMAIL());
 *
 * // If the user enters data that doesn't match the email pattern,
 * // a message "Please enter a valid email address." will be displayed above the input.
 * ```
 */
class RegexValidator extends Validator {
	/**
	 * @param string $pattern The regular expression pattern to validate against
	 * @param string $error   The error message to return if validation fails
	 */
	public function __construct(
		protected string $pattern,
		string $error = Validator::DEFAULT_ERROR
	) {
		parent::__construct($pattern, $error);
	}

	/**
	 * Validate the given data against the regular expression pattern.
	 *
	 * @param mixed $data The data to validate
	 *
	 * @return string|null Returns an error message if validation fails, or null if valid
	 */
	public function validate(mixed $data) : ?string {
		return !preg_match($this->pattern, (string) $data) ? $this->error() : null;
	}

	/**
	 * Create an email validator.
	 *
	 * @param string $error The error message for invalid email addresses
	 *
	 * @return self Returns a new instance of RegexValidator for email validation
	 */
	public static function EMAIL(string $error = 'Please enter a valid email address.') : self {
		// Regular expression pattern for validating email addresses
		$emailPattern = '/^[\w\.\-]+@([\w\-]+\.)+[a-zA-Z]{2,7}$/';
		return new self($emailPattern, $error);
	}
}
