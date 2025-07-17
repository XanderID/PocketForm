<?php

declare(strict_types=1);

namespace XanderID\PocketForm\custom\validator;

use InvalidArgumentException;
use function implode;

/**
 * Chains multiple validators together and runs them in sequence.
 *
 * You can choose to either stop at the first validation error
 * or continue evaluating all validators and return all errors.
 *
 * Example usage:
 * ```php
 * $chain = new ValidatorChain([
 *     RegexValidator::EMAIL(),
 *     TypeValidator::string()
 * ]);
 * $input->validator($chain->displayAllErrors(true));
 * ```
 */
class ValidatorChain extends Validator {
	/** @var array<Validator> List of validators to apply in sequence */
	protected array $validators;

	/** @var bool Whether to collect all errors or stop at the first */
	protected bool $showAllErrors = false;

	/**
	 * @param Validator ...$validators One or more validator instances
	 */
	public function __construct(Validator ...$validators) {
		parent::__construct('ValidatorChain', 'Validation failed.');
		$this->validators = $validators;
	}

	/**
	 * Create a ValidatorChain from an array of validators.
	 *
	 * @param array<Validator> $validators
	 */
	public static function create(array $validators) : self {
		return new self(...$validators);
	}

	/**
	 * Add a validator to the chain.
	 */
	public function add(Validator $validator) : self {
		$this->validators[] = $validator;
		return $this;
	}

	/**
	 * Specify whether to return all error messages or stop on the first failure.
	 *
	 * @param bool $value True to return all error messages, false to stop at first error
	 */
	public function showAllErrors(bool $value) : self {
		$this->showAllErrors = $value;
		return $this;
	}

	/**
	 * Validates the given data against all registered validators.
	 *
	 * @return string|null A single error message, multiple error messages joined by newline, or null if valid
	 *
	 * @throws InvalidArgumentException
	 */
	public function validate(mixed $data) : ?string {
		$errors = [];

		foreach ($this->validators as $validator) {
			$error = $validator->validate($data);
			if ($error !== null) {
				if (!$this->showAllErrors) {
					return $error;
				}

				$errors[] = $error;
			}
		}

		return !empty($errors) ? implode("\n", $errors) : null;
	}
}
