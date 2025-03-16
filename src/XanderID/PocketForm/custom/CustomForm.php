<?php

declare(strict_types=1);

namespace XanderID\PocketForm\custom;

use pocketmine\player\Player;
use XanderID\PocketForm\custom\element\ErrorLabel;
use XanderID\PocketForm\custom\element\Input;
use XanderID\PocketForm\modal\ModalFormResponse;
use XanderID\PocketForm\PocketForm;
use XanderID\PocketForm\traits\Confirm;
use XanderID\PocketForm\traits\Submit;
use XanderID\PocketForm\Utils;

/**
 * Represents a custom form that can contain various custom elements.
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
	 * @param string $title the title of the custom form
	 */
	public function __construct(string $title) {
		$this->setSubmit(self::DEFAULT_SUBMIT);
		parent::__construct($title);
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
	 * Process the custom form response data.
	 *
	 * @param Player $player the player who submitted the form
	 * @param mixed  $data   the raw response data
	 */
	public function callOnResponse(Player $player, mixed $data) : void {
		$values = [];
		$elements = $this->getElements();
		$errorLabels = [];
		$isError = false;
		foreach ($data as $index => $value) {
			/** @var CustomElement $element */
			$element = $elements[$index];
			if (null === $value) {
				continue;
			}

			$parsed = Utils::customValue($element, $value);
			$validated = $element->validate($parsed);
			$previous = $elements[$index - 1] ?? null;
			if (null !== $validated) {
				if (!$previous instanceof ErrorLabel) {
					$errorLabels[$index] = new ErrorLabel($validated);
				}

				$isError = true;
			} else {
				if ($previous instanceof ErrorLabel) {
					unset($elements[$index - 1]);
				}
			}

			$values[] = $parsed;
			$element->setValue($parsed);

			/**
			 * This is actually a CustomElement except Label, Used for Dummy Error Only.
			 *
			 * @var Input $element
			 */
			$element->setDefault($value);
		}

		if ($isError) {
			$newElements = [];
			foreach ($elements as $index => $element) {
				if (isset($errorLabels[$index])) {
					$newElements[] = $errorLabels[$index];
				}

				$newElements[] = $element;
			}

			$this->setElements($newElements);
			$player->sendForm($this);
			return;
		}

		if (null !== ($confirm = $this->getConfirm())) {
			$confirm->onResponse(function (ModalFormResponse $response) use ($values) : void {
				$player = $response->getPlayer();
				parent::callOnResponse($player, $values);
			});
			$player->sendForm($confirm);
			return;
		}

		parent::callOnResponse($player, $values);
	}

	/**
	 * Initialize form components specific to custom forms.
	 *
	 * @return array an array containing custom components
	 */
	protected function initComponents() : array {
		return [
			'submit' => $this->submit,
		];
	}
}
