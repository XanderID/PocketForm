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

use XanderID\PocketForm\custom\element\Input;
use XanderID\PocketForm\custom\validator\TypeValidator;
use XanderID\PocketForm\Element;
use XanderID\PocketForm\PocketFormException;
use XanderID\PocketForm\traits\FormLabel;
use XanderID\PocketForm\traits\FormValidator;
use XanderID\PocketForm\traits\FormValue;
use XanderID\PocketForm\Utils;

/**
 * Represents a custom form element with additional functionalities like validation and value storage.
 */
abstract class CustomElement extends Element {
	use FormLabel;
	use FormValidator;
	use FormValue;

	/**
	 * Returns the supported form type for this element.
	 *
	 * @return array<string> The supported form type
	 */
	public function supportForm() : array {
		return [Utils::FORM_TYPES[2]];
	}

	/**
	 * Perform build check for the CustomElement.
	 *
	 * @throws PocketFormException if an invalid validator is used
	 */
	public function buildCheck() : void {
		$validator = $this->getValidator();
		if ($validator === null) {
			return;
		}

		if (!($this instanceof Input) && $validator instanceof TypeValidator) {
			throw new PocketFormException('This element cannot use TypeValidator!');
		}
	}
}
