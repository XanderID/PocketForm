<?php

declare(strict_types=1);

namespace XanderID\PocketForm\simple;

use XanderID\PocketForm\PocketFormException;
use XanderID\PocketForm\simple\element\Button;
use XanderID\PocketForm\simple\element\ButtonImage;
use XanderID\PocketForm\Utils;

/**
 * Provides helper methods to add buttons to a simple form.
 */
trait SimpleHelper {
	/**
	 * Add a button element.
	 *
	 * @param string   $text      the text for the button
	 * @param int|null $imageType the image type (0 for PATH, otherwise URL)
	 * @param string   $imageUri  the URI for the button image
	 */
	public function addButton(string $text, ?int $imageType = null, string $imageUri = '') : self {
		$image = null !== $imageType ? ButtonImage::create($imageType, $imageUri) : null;
		$button = new Button($text, $image);
		$this->addElement($button);
		return $this;
	}

	/**
	 * Add multiple buttons.
	 *
	 * @param array $buttons an array of button texts
	 *
	 * @throws PocketFormException if any of the values in the array are not strings
	 */
	public function addButtons(array $buttons) : self {
		if (Utils::validateArrayValueType($buttons, function (string $button) : void {})) {
			throw new PocketFormException('Failed to build buttons Element: Buttons array can only be strings!');
		}

		foreach ($buttons as $text) {
			$button = new Button($text);
			$this->addElement($button);
		}

		return $this;
	}
}
