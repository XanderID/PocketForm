<?php

declare(strict_types=1);

namespace XanderID\PocketForm\custom;

use XanderID\PocketForm\custom\validator\TypeValidator;
use XanderID\PocketForm\Element;
use XanderID\PocketForm\PocketFormException;
use XanderID\PocketForm\traits\FormLabel;
use XanderID\PocketForm\traits\FormValidator;
use XanderID\PocketForm\traits\FormValue;

/**
 * Represents a custom form element with additional functionalities like validation and value storage.
 */
abstract class CustomElement extends Element {
	use FormLabel;
	use FormValidator;
	use FormValue;

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

		if (!($this instanceof \XanderID\PocketForm\custom\element\Input) && $validator instanceof TypeValidator) {
			throw new PocketFormException('This element cannot use TypeValidator!');
		}
	}
}
