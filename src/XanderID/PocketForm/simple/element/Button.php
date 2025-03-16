<?php

declare(strict_types=1);

namespace XanderID\PocketForm\simple\element;

use XanderID\PocketForm\Element;
use XanderID\PocketForm\traits\Confirm;
use XanderID\PocketForm\traits\onClick;

/**
 * Represents a button element within a simple form.
 */
class Button extends Element {
	use Confirm;
	use onClick;

	/** @var int|null internal ID for the button */
	private ?int $id = null;

	/** @var mixed custom ID for the button (if provided) */
	private mixed $customId = null;

	/**
	 * @param string           $text  the text displayed on the button
	 * @param ButtonImage|null $image optional image for the button
	 */
	public function __construct(
		public string $text,
		public ?ButtonImage $image = null
	) {}

	/**
	 * Get the button ID.
	 *
	 * @return mixed returns the custom ID if set; otherwise, the internal ID
	 */
	public function getId() : mixed {
		return null !== $this->customId ? $this->customId : $this->id;
	}

	/**
	 * Set the internal button ID.
	 *
	 * @param int $id the internal ID
	 */
	public function setId(int $id) : self {
		$this->id = $id;
		return $this;
	}

	/**
	 * Set a custom ID for the button.
	 *
	 * @param mixed $id the custom ID
	 */
	public function setCustomId(mixed $id) : self {
		$this->customId = $id;
		return $this;
	}

	/**
	 * Get the element type.
	 *
	 * @return string returns "button"
	 */
	public function getType() : string {
		return 'button';
	}

	/**
	 * Set the button text.
	 *
	 * @param string $text the new button text
	 */
	public function setText(string $text) : self {
		$this->text = $text;
		return $this;
	}

	/**
	 * Get the button text.
	 *
	 * @return string the button text
	 */
	public function getText() : string {
		return $this->text;
	}

	/**
	 * Get the button image.
	 *
	 * @return ButtonImage|null the associated button image, if any
	 */
	public function getImage() : ?ButtonImage {
		return $this->image;
	}

	/**
	 * Set the button image.
	 *
	 * @param ButtonImage $image the button image
	 */
	public function setImage(ButtonImage $image) : self {
		$this->image = $image;
		return $this;
	}

	/**
	 * Build the button element.
	 *
	 * @param array &$components The components array to add the button to
	 */
	public function build(array &$components) : void {
		$button = ['text' => $this->text];
		$this->image?->build($button);
		$components['buttons'][] = $button;
	}
}
