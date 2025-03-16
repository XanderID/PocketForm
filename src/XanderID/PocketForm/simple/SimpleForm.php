<?php

declare(strict_types=1);

namespace XanderID\PocketForm\simple;

use pocketmine\player\Player;
use XanderID\PocketForm\modal\ModalFormResponse;
use XanderID\PocketForm\PocketForm;
use XanderID\PocketForm\simple\element\Button;
use XanderID\PocketForm\traits\Body;

/**
 * Represents a simple form with a list of buttons.
 */
class SimpleForm extends PocketForm {
	use Body;
	use SimpleHelper;

	/**
	 * Get the form type.
	 *
	 * @return string returns "form"
	 */
	protected function getType() : string {
		return 'form';
	}

	/**
	 * Get the response class name.
	 *
	 * @return string returns the class name for simple form responses
	 */
	protected function getResponseClass() : string {
		return SimpleFormResponse::class;
	}

	/**
	 * Get the callback signature for simple form responses.
	 *
	 * @return callable the expected signature for the onResponse callback
	 */
	protected function getSignature() : callable {
		return function (SimpleFormResponse $response) : void {};
	}

	/**
	 * Initialize simple form components.
	 *
	 * @return array an associative array containing the form content
	 */
	protected function initComponents() : array {
		return [
			'content' => $this->body,
		];
	}

	/**
	 * Process the simple form response and handle button callbacks.
	 *
	 * @param Player $player the player who submitted the form
	 * @param mixed  $data   the raw response data
	 */
	public function callOnResponse(Player $player, mixed $data) : void {
		/** @var Button $selected */
		$selected = $this->getElement($data);
		if (null !== ($confirm = $selected->getConfirm())) {
			$confirm->onResponse(function (ModalFormResponse $response) use ($selected, $data) : void {
				$player = $response->getPlayer();
				if ($selected->isOnClick()) {
					$selected->onClickCall($player);
					return;
				}

				parent::callOnResponse($player, $data);
			});
			$player->sendForm($confirm);
			return;
		}

		if ($selected->isOnClick()) {
			$selected->onClickCall($player);
			return;
		}

		parent::callOnResponse($player, $data);
	}
}
