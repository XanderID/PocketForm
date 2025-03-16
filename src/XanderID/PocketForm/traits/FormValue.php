<?php

declare(strict_types=1);

namespace XanderID\PocketForm\traits;

/**
 * Provides methods to set and get the value of a form element.
 */
trait FormValue {
	/** @var mixed the value of the element */
	protected mixed $value;

	/**
	 * Get the current value.
	 *
	 * @return mixed the current value
	 */
	public function getValue() : mixed {
		return $this->value;
	}

	/**
	 * Set the value.
	 *
	 * @param mixed $value the value to set
	 */
	public function setValue(mixed $value) : void {
		$this->value = $value;
	}
}
