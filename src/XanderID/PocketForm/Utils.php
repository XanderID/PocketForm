<?php

declare(strict_types=1);

namespace XanderID\PocketForm;

use Closure;
use pocketmine\player\Player;
use pocketmine\utils\Utils as PMUtils;
use XanderID\PocketForm\custom\CustomElement;
use XanderID\PocketForm\custom\element\Dropdown;
use XanderID\PocketForm\custom\element\Input;
use XanderID\PocketForm\custom\element\Label;
use XanderID\PocketForm\custom\element\Slider;
use XanderID\PocketForm\custom\element\StepSlider;
use XanderID\PocketForm\custom\element\Toggle;
use XanderID\PocketForm\custom\validator\TypeValidator;
use XanderID\PocketForm\simple\SimpleFormResponse;

/**
 * Contains utility methods for validation, array manipulation, and menu callable.
 */
class Utils {
	/**
	 * Convert the value based on the specific CustomElement type.
	 *
	 * @param CustomElement $element the element for which the value is being processed
	 * @param mixed         $value   the raw value from the form response
	 *
	 * @return mixed the converted value
	 */
	public static function customValue(CustomElement $element, mixed $value) : mixed {
		if ($element instanceof Input) {
			$validator = $element->getValidator();
			if ($validator instanceof TypeValidator) {
				return $validator->parseText($value);
			}
		}

		return match (true) {
			$element instanceof Dropdown => (string) $element->getOptions()[$value],
			$element instanceof Input => (string) $value,
			$element instanceof Label => (string) $element->getLabel(),
			$element instanceof Slider => (int) $value,
			$element instanceof StepSlider => (int) $element->getStep()[$value],
			$element instanceof Toggle => (bool) $value,
			default => $value,
		};
	}

	/**
	 * Validate the type of each value in an array using a provided closure.
	 *
	 * @param array   $array     the array whose values will be validated
	 * @param Closure $validator a closure that accepts a value and validates it
	 *
	 * @return bool returns true if any value fails validation, otherwise false
	 */
	public static function validateArrayValueType(array $array, Closure $validator) : bool {
		foreach ($array as $k => $v) {
			try {
				$validator($v);
			} catch (\TypeError $e) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Validate that all elements in an array are instances of Element.
	 *
	 * @param array  $elements the array of elements to validate
	 * @param string $header   the error message prefix if validation fails
	 *
	 * @throws PocketFormException if any element is not an instance of Element
	 */
	public static function validateArrayElement(array $elements, string $header = 'Failed to create Elements') : void {
		if (self::validateArrayValueType($elements, function (Element $element) : void {})) {
			throw new PocketFormException($header . ': Elements array can only be Element!');
		}
	}

	/**
	 * Create a callable for a menu form that maps button selections to callbacks.
	 *
	 * @param array $callables an array of callables corresponding to each button
	 *
	 * @return Closure returns a closure that processes the form response
	 *
	 * @throws PocketFormException if any callable is invalid
	 */
	public static function createMenuCall(array $callables) : Closure {
		if (self::validateArrayValueType($callables, function (callable $callable) {
			// Dummy so that it is not fixed to void by PHP CS Fixer
			return null;
		})) {
			throw new PocketFormException('Failed to Build Closure: Callables array can only be callable!');
		}

		foreach ($callables as $callable) {
			PMUtils::validateCallableSignature(function (Player $player) {
				// Dummy so that it is not fixed to void by PHP CS Fixer
				return null;
			}, $callable);
		}

		$onResponse = function (SimpleFormResponse $response) use ($callables) : void {
			$player = $response->getPlayer();
			$selected = $response->getSelected();
			$index = $selected->getId();
			if (($callable = $callables[$index] ?? null) !== null) {
				$callable($player);
			}
		};
		return $onResponse;
	}
}
