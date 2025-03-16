<?php

declare(strict_types=1);

namespace XanderID\PocketForm\traits;

/**
 * Provides methods to set and get the label of a form element.
 */
trait FormLabel {
	/** @var string the form label */
	protected string $label = '';

	/**
	 * Get the label.
	 *
	 * @return string the current label
	 */
	public function getLabel() : string {
		return $this->label;
	}

	/**
	 * Set the label.
	 *
	 * @param string $label the new label
	 */
	public function setLabel(string $label) : self {
		$this->label = $label;
		return $this;
	}
}
