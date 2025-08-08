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

use pocketmine\lang\Translatable;
use XanderID\PocketForm\custom\element\Dropdown;
use XanderID\PocketForm\custom\element\Input;
use XanderID\PocketForm\custom\element\Slider;
use XanderID\PocketForm\custom\element\StepSlider;
use XanderID\PocketForm\custom\element\Toggle;
use XanderID\PocketForm\element\extends\ReadonlyElement;
use XanderID\PocketForm\element\Label;
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
 * @phpstan-type NonFloatScalar string|int|bool|Translatable
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
		if (Utils::validateArrayValueType($data, function (bool|int|string|Translatable $data) : void {})) {
			throw new PocketFormException('Invalid response data: all elements must be bool, int, string or Translatable.');
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

	/**
	 * Resends the form to the player.
	 *
	 * If the $withPreviousData is true,
	 * the form will be prefilled with the player's previously submitted data.
	 *
	 * @param bool $withPreviousData whether to restore the previously submitted data into the form
	 */
	public function resendForm(bool $withPreviousData = true) : void {
		/** @var array<int, scalar|null> $data */
		$data = $this->data;
		$elements = $this->form->getElements();
		$mapData = Utils::customMap($elements, $data);

		foreach ($mapData as $index => $_) {
			/** @var CustomElement|Label $element */
			$element = $elements[$index];
			if ($element instanceof ReadonlyElement) {
				continue;
			}

			$this->form->clearErrorLabels();

			/**
			 * @var Dropdown|Input|Slider|StepSlider|Toggle $element
			 * @var bool|float|int|string $newValue
			 */
			$newValue = $withPreviousData ? $element->getDefault() : Utils::defaultValue($element);
			$this->form->applyDefaultValue($element, $newValue);
		}

		$this->player->sendForm($this->form);
	}
}
