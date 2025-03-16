<?php

declare(strict_types=1);

namespace XanderID\PocketForm;

use Closure;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\Utils;
use XanderID\PocketForm\traits\Elements;
use function gettype;
use function is_array;
use function is_bool;
use function is_int;

/**
 * Represents a base form with functionality for handling responses,
 * closing, and building components.
 */
abstract class PocketForm implements Form {
	use Elements;

	/** @var Closure|null callback for handling the form response */
	protected ?Closure $onResponseListener = null;

	/** @var Closure|null callback for handling the form close event */
	protected ?Closure $onCloseListener = null;

	/**
	 * @param string $title the title of the form
	 */
	public function __construct(protected string $title) {}

	/**
	 * Get the type of the form.
	 *
	 * @return string The form type (e.g., "modal", "custom_form", "form").
	 */
	abstract protected function getType() : string;

	/**
	 * Get the response class name for the form.
	 *
	 * @return string the fully qualified class name used to process the response
	 */
	abstract protected function getResponseClass() : string;

	/**
	 * Get the signature (callback structure) for the onResponse function.
	 *
	 * @return callable a callable that defines the expected signature of the onResponse callback
	 */
	abstract protected function getSignature() : callable;

	/**
	 * Initialize additional form components.
	 *
	 * @return array an associative array of additional components
	 */
	abstract protected function initComponents() : array;

	/**
	 * Set the form title.
	 *
	 * @param string $title the new title for the form
	 *
	 * @return self returns the current form instance
	 */
	public function setTitle(string $title) : self {
		$this->title = $title;
		return $this;
	}

	/**
	 * Set the onResponse callback.
	 *
	 * @param Closure $onResponse The callback to be executed when a response is received.
	 *                            The callback should follow the signature defined by {@see getSignature()}.
	 *
	 * @return self returns the current form instance
	 */
	public function onResponse(Closure $onResponse) : self {
		Utils::validateCallableSignature($this->getSignature(), $onResponse);
		$this->onResponseListener = $onResponse;
		return $this;
	}

	/**
	 * Call the onResponse callback with the processed response.
	 *
	 * @param Player $player the player who submitted the form
	 * @param mixed  $data   the raw response data
	 *
	 * @throws PocketFormException if the response class is not valid
	 */
	public function callOnResponse(Player $player, mixed $data) : void {
		$responseClass = $this->getResponseClass();
		Utils::testValidInstance($responseClass, PocketFormResponse::class);
		$response = new $responseClass($player, $this, $data);
		$this->onResponseListener?->__invoke($response);
	}

	/**
	 * Set the onClose callback.
	 *
	 * @param Closure $onClose The callback to be executed when the form is closed without a response.
	 *                         The callback must accept a Player parameter.
	 *
	 * @return self returns the current form instance
	 */
	public function onClose(Closure $onClose) : self {
		Utils::validateCallableSignature(function (Player $player) : void {}, $onClose);
		$this->onCloseListener = $onClose;
		return $this;
	}

	/**
	 * Handle the form response by determining if it's a valid response or a close event.
	 *
	 * @param Player $player the player who interacted with the form
	 * @param mixed  $data   the response data (can be bool, int, array, or null)
	 *
	 * @throws PocketFormException if the data type is not expected
	 */
	public function handleResponse(Player $player, mixed $data) : void {
		match (true) {
			null === $data => $this->onCloseListener?->__invoke($player),
			is_bool($data) || is_int($data) || is_array($data) => $this->callOnResponse($player, $data),
			default => throw new PocketFormException('Expected bool, int, array, or null, got ' . gettype($data)),
		};
	}

	/**
	 * Serialize the form to an array suitable for JSON encoding.
	 *
	 * @return array the array representation of the form
	 */
	public function jsonSerialize() : array {
		$components = $this->initComponents();
		$components['type'] = $this->getType();
		$components['title'] = $this->title;
		$this->buildElements($components);
		return $components;
	}
}
