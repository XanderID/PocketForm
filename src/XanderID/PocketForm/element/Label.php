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

namespace XanderID\PocketForm\element;

use XanderID\PocketForm\traits\FormLabel;
use XanderID\PocketForm\Utils;

/**
 * Represents a label element used to display static text.
 */
class Label extends ReadonlyElement {
	use FormLabel;

	/**
	 * @param string $label the text for the label element
	 */
	public function __construct(string $label) {
		$this->setLabel($label);
	}

	/**
	 * Returns the supported form type.
	 * Only works in CustomForm due to lack of key support in SimpleForm.
	 *
	 * @return array<string> The supported form type
	 */
	public function supportForm() : array {
		return [Utils::FORM_TYPES[2]];
	}

	/**
	 * Get the element type.
	 *
	 * @return string returns "label"
	 */
	public function getType() : string {
		return 'label';
	}

	/**
	 * Build the label element.
	 *
	 * @param array<string, list<mixed>> &$components The components array to add the label to
	 */
	public function build(array &$components) : void {
		$label = ['type' => $this->getType(), 'text' => $this->label];
		$components['content'][] = $label;
	}
}
