<?php

declare(strict_types=1);

namespace XanderID\PocketForm;

use pocketmine\player\Player;

/**
 * Represents a response from a form submitted by a player.
 */
abstract class PocketFormResponse {
	/**
	 * @param Player     $player the player who submitted the response
	 * @param PocketForm $form   the form that was submitted
	 * @param mixed      $data   the raw response data
	 */
	public function __construct(
		public Player $player,
		public PocketForm $form,
		public mixed $data
	) {
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
	 */
	public function getForm() : PocketForm {
		return $this->form;
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
