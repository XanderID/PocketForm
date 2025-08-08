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
use pocketmine\player\Player;
use XanderID\PocketForm\custom\element\Dropdown;
use XanderID\PocketForm\custom\element\Input;
use XanderID\PocketForm\custom\element\Slider;
use XanderID\PocketForm\custom\element\StepSlider;
use XanderID\PocketForm\custom\element\Toggle;
use XanderID\PocketForm\element\ErrorLabel;
use XanderID\PocketForm\element\extends\Element;
use XanderID\PocketForm\element\extends\ReadonlyElement;
use XanderID\PocketForm\element\Label;
use XanderID\PocketForm\modal\ModalFormResponse;
use XanderID\PocketForm\PocketForm;
use XanderID\PocketForm\PocketFormException;
use XanderID\PocketForm\traits\Confirm;
use XanderID\PocketForm\traits\Submit;
use XanderID\PocketForm\Utils;
use XanderID\PocketForm\utils\Translate;
use function array_filter;
use function array_values;
use function count;
use function gettype;
use function is_array;

/**
 * Represents a custom form that can contain various custom elements.
 *
 * @extends PocketForm<CustomFormResponse>
 */
class CustomForm extends PocketForm {
	use Submit;
	use Confirm;
	use CustomHelper;

	/**
	 * Default submit text.
	 *
	 * @var string
	 */
	public const DEFAULT_SUBMIT = 'gui.submit';

	/**
	 * @param string|Translatable $title the title of the custom form
	 */
	public function __construct(string|Translatable $title) {
		$this->setSubmit(self::DEFAULT_SUBMIT);
		parent::__construct($title);
	}

	/**
	 * Creates a new CustomForm instance.
	 *
	 * @param string|Translatable $title the title of the custom form
	 */
	public static function create(string|Translatable $title) : self {
		return new self($title);
	}

	/**
	 * Get the form type.
	 *
	 * @return string returns "custom_form"
	 */
	protected function getType() : string {
		return 'custom_form';
	}

	/**
	 * Get the response class name.
	 *
	 * @return string returns the class name for processing custom form responses
	 */
	protected function getResponseClass() : string {
		return CustomFormResponse::class;
	}

	/**
	 * Get the callback signature for the custom form response.
	 *
	 * @return callable the expected signature for the onResponse callback
	 */
	protected function getSignature() : callable {
		return function (CustomFormResponse $response) : void {};
	}

	/**
	 * Set default value to the given interactive element.
	 *
	 * @param Dropdown|Input|Slider|StepSlider|Toggle $element target element
	 * @param bool|float|int|string                   $value   value to set as default
	 */
	public function applyDefaultValue(Dropdown|Input|Slider|StepSlider|Toggle $element, bool|float|int|string $value) : void {
		$element->setDefault($value);
	}

	/**
	 * Removes all ErrorLabel elements from the form.
	 */
	public function clearErrorLabels() : void {
		$elements = array_filter(
			$this->getElements(),
			fn (Element $el) => !$el instanceof ErrorLabel
		);

		$this->setElements(array_values($elements));
	}

	/**
	 * Validates and manages errors, updating error label list and state flag.
	 *
	 * @param array<int, ErrorLabel> &$errorLabels
	 * @param array<int, Element>    &$elements
	 *
	 * @return bool Whether the validation failed
	 */
	public function validateAndHandleError(
		CustomElement $element,
		mixed $parsed,
		array &$errorLabels,
		array &$elements,
		int $index
	) : bool {
		$prevIndex = $index - 1;
		$previous = $elements[$prevIndex] ?? null;

		if ($previous instanceof ErrorLabel) {
			unset($elements[$prevIndex]);
		}

		$validated = $element->validate($parsed);

		if ($validated !== null) {
			$errorLabels[$index] = new ErrorLabel($validated);
			return true;
		}

		return false;
	}

	/**
	 * Rebuilds form with error labels if needed.
	 *
	 * @param array<int, Element>    $elements
	 * @param array<int, ErrorLabel> $errorLabels
	 */
	public function rebuildFormIfError(array $elements, array $errorLabels, Player $player) : void {
		$newElements = [];
		foreach ($elements as $index => $element) {
			if (isset($errorLabels[$index])) {
				$newElements[] = $errorLabels[$index];
			}

			$newElements[] = $element;
		}

		$this->setElements($newElements);
		$player->sendForm($this);
	}

	/**
	 * Process the custom form response data.
	 *
	 * @param Player $player the player who submitted the form
	 * @param mixed  $data   the raw response data; expected to be an array with int keys and values of type bool|int|string|null
	 *
	 * @throws PocketFormException if $data is not iterable
	 */
	public function callOnResponse(Player $player, mixed $data) : void {
		if (!is_array($data)) {
			throw new PocketFormException('Expected response data to be an array, got ' . gettype($data));
		}

		/** @var array<int, scalar|null> $data */
		$values = [];
		$elements = $this->getElements();
		$mapData = Utils::customMap($elements, $data);
		$errorLabels = [];
		$isError = false;

		foreach ($mapData as $index => $value) {
			/** @var CustomElement|Label $element */
			$element = $elements[$index];

			if ($element instanceof ReadonlyElement) {
				continue;
			}

			/** @var bool|float|int|string $value */
			$parsed = Utils::customValue($element, $value);
			$isError |= $this->validateAndHandleError($element, $parsed, $errorLabels, $elements, (int) $index);

			$values[] = $parsed;
			$element->setValue($parsed);

			/**
			 * @var Dropdown|Input|Slider|StepSlider|Toggle $element
			 * @var bool|float|int|string $value
			 */
			$this->applyDefaultValue($element, $value);
		}

		if ($isError) {
			$this->rebuildFormIfError($elements, $errorLabels, $player);
			return;
		}

		if (null !== ($confirm = $this->getConfirm())) {
			$confirm->onResponse(function (ModalFormResponse $response) use ($values) : void {
				$player = $response->getPlayer();
				if ($response->getChoice()) {
					parent::callOnResponse($player, $values);
				}
			});
			$player->sendForm($confirm);
			return;
		}

		parent::callOnResponse($player, $values);
	}

	/**
	 * Initialize form components specific to custom forms.
	 *
	 * @return array<string, mixed> an array containing custom components
	 */
	protected function initComponents() : array {
		return [
			'submit' => Translate::translate($this->submit),
			'content' => [],
		];
	}

	/**
	 * Serialize the form to an array suitable for JSON encoding.
	 *
	 * @return array<string, mixed> the array representation of the form
	 *
	 * @throws PocketFormException If the CustomForm cannot be built
	 */
	public function jsonSerialize() : array {
		$elements = $this->getElements();
		if (count($elements) < 1) {
			throw new PocketFormException('Failed to build Custom Form: Please add at least 1 element');
		}

		return parent::jsonSerialize();
	}
}
