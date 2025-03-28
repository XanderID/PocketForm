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

namespace XanderID\PocketForm;

/**
 * Represents a form element which can be built into a set of components.
 */
abstract class Element {
	/**
	 * Get the type of the element.
	 *
	 * @return string|null The element type (e.g., "input", "dropdown") or null if not defined.
	 */
	abstract public function getType() : ?string;

	/**
	 * Build the element into the components array.
	 *
	 * @param array<string, mixed> &$components The array to which the element's component will be appended
	 */
	abstract public function build(array &$components) : void;

	/**
	 * Perform any necessary checks before building the element.
	 *
	 * This method can be overridden by subclasses to validate element properties.
	 */
	public function buildCheck() : void {}

	/**
	 * Throws an exception if the element cannot be built.
	 *
	 * @param string $error the error message describing the build failure
	 *
	 * @throws PocketFormException always thrown to indicate a build error
	 */
	protected function buildError(string $error) : void {
		$elementName = (new \ReflectionClass(static::class))->getShortName();
		throw new PocketFormException('Failed to build ' . $elementName . ' Element: ' . $error);
	}
}
