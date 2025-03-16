<?php

declare(strict_types=1);

namespace XanderID\PocketForm\custom\validator;

use Closure;
use pocketmine\utils\Utils;

/**
 * Provides a custom validator that uses a Closure for validation.
 *
 * Example usage:
 * ```
 *	$bannedWords = ['spam', 'scam', 'phishing'];
 *
 *	$validator = new CustomValidator(function($data) use ($bannedWords): ?string {
 *		if (in_array($data, $bannedWords)) {
 *			return "The input contains a banned word: {$word}.";
 *		}
 *		return null;
 *	});
 *
 *	$comment = new Input('Comment', 'Input Comment.');
 *	$comment->validator($validator);
 *
 *	// If the input contains any banned word,
 *	// an error message such as "The input contains a banned word: spam." will be shown.
 * ```
 */
class CustomValidator extends Validator {
	/**
	 * @param Closure $validator the validation function that accepts mixed data and returns a string error message if validation fails,
	 *                           or null if the data is valid
	 */
	public function __construct(Closure $validator) {
		Utils::validateCallableSignature(function ($data) : ?string {
			return null;
		}, $validator);
		parent::__construct($validator);
	}

	/**
	 * Validate the given data.
	 *
	 * @param mixed $data the data to validate
	 *
	 * @return string|null returns an error message if validation fails, or null if the data is valid
	 */
	public function validate(mixed $data) : ?string {
		return ($this->validator)($data);
	}
}
