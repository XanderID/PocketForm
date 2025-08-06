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

namespace XanderID\PocketForm;

use pocketmine\player\Player;
use XanderID\PocketForm\custom\CustomElement;
use XanderID\PocketForm\custom\CustomForm;
use XanderID\PocketForm\custom\element\Dropdown;
use XanderID\PocketForm\custom\element\Input;
use XanderID\PocketForm\custom\element\Slider;
use XanderID\PocketForm\custom\element\StepSlider;
use XanderID\PocketForm\custom\element\Toggle;
use XanderID\PocketForm\element\ErrorLabel;
use XanderID\PocketForm\element\extends\ReadonlyElement;
use XanderID\PocketForm\element\Label;

/**
 * Represents a response from a form submitted by a player.
 *
 * @template F of PocketForm
 */
abstract class PocketFormResponse {
	/** @var F */
	public PocketForm $form;

	/**
	 * @param Player $player the player who submitted the response
	 * @param F      $form   the form that was submitted
	 * @param mixed  $data   the raw response data
	 */
	public function __construct(
		public Player $player,
		PocketForm $form,
		public mixed $data
	) {
		$this->form = $form;
		$this->processData($data);
	}

	/**
	 * Get the player who submitted the response.
	 */
	public function getPlayer() : Player {
		return $this->player;
	}

	/**
	 * Get the raw response data.
	 *
	 * @return mixed the unprocessed response data
	 */
	public function getRawData() : mixed {
		return $this->data;
	}

	/**
	 * Get the form that was submitted.
	 *
	 * @return F
	 */
	public function getForm() : PocketForm {
		return $this->form;
	}

	/**
	 * Resends the form to the player.
	 *
	 * If the form is a CustomForm and $withPreviousData is true,
	 * the form will be prefilled with the player's previously submitted data.
	 *
	 * @param bool $withPreviousData whether to restore the previously submitted data into the form
	 */
	public function resendForm(bool $withPreviousData = true) : void {
		if ($this->form instanceof CustomForm) {
			/** @var array<int, scalar|null> $data */
			$data = $this->data;
			$elements = $this->form->getElements();
			$mapData = Utils::customMap($elements, $data);
			foreach ($mapData as $index => $value) {
				/** @var CustomElement|Label $element */
				$element = $elements[$index];
				if ($element instanceof ReadonlyElement) {
					continue;
				}

				$indexInt = (int) $index;
				$previous = $elements[$indexInt - 1] ?? null;
				if ($previous instanceof ErrorLabel) {
					$this->form->removeElement($indexInt - 1);
				}

				/**
				 * Set the default value based on previously submitted data.
				 *
				 * @var Dropdown|Input|Slider|StepSlider|Toggle $element
				 * @var bool|float|int|string $newValue
				 */
				$newValue = $withPreviousData ? $element->getDefault() : Utils::defaultValue($element);
				$element->setDefault($newValue);
			}
		}

		$this->player->sendForm($this->form);
	}

	/**
	 * Process the raw response data.
	 *
	 * This method should transform or validate the data as needed.
	 *
	 * @param mixed $data the raw response data
	 */
	abstract public function processData(mixed $data) : void;
}
