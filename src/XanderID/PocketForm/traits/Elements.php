<?php

declare(strict_types=1);

namespace XanderID\PocketForm\traits;

use XanderID\PocketForm\Element;
use XanderID\PocketForm\Utils;
use function array_merge;

/**
 * Provides methods for managing a collection of elements.
 */
trait Elements {
	/** @var list<Element> list of elements */
	protected array $elements = [];

	/**
	 * Get an element by its index.
	 *
	 * @param int $index the index of the element
	 *
	 * @return Element|null returns the element if found, or null otherwise
	 */
	public function getElement(int $index) : ?Element {
		return $this->elements[$index] ?? null;
	}

	/**
	 * Set the entire array of elements.
	 *
	 * @param array $elements an array of Element instances
	 *
	 * @throws \Exception if validation fails
	 */
	public function setElements(array $elements) : self {
		Utils::validateArrayElement($elements, 'Failed to set Elements');
		$this->elements = $elements;
		return $this;
	}

	/**
	 * Get all elements.
	 *
	 * @return list<Element> an array of Element instances
	 */
	public function getElements() : array {
		return $this->elements;
	}

	/**
	 * Add an element to the collection.
	 *
	 * @param Element $element the element to add
	 */
	public function addElement(Element $element) : self {
		$this->elements[] = $element;
		return $this;
	}

	/**
	 * Set an element at a specific index.
	 *
	 * @param int     $index   the index to set
	 * @param Element $element the element to set
	 */
	public function setElement(int $index, Element $element) : self {
		$this->elements[$index] = $element;
		return $this;
	}

	/**
	 * Remove an element by its index.
	 *
	 * @param int $index the index of the element to remove
	 */
	public function removeElement(int $index) : self {
		if (isset($this->elements[$index])) {
			unset($this->elements[$index]);
		}

		return $this;
	}

	/**
	 * Merge additional elements into the current collection.
	 *
	 * @param array $elements an array of Element instances to merge
	 *
	 * @throws \Exception if validation fails
	 */
	public function mergeElement(array $elements) : self {
		Utils::validateArrayElement($elements, 'Failed to merge Elements');
		$this->elements = array_merge($this->elements, $elements);
		return $this;
	}

	/**
	 * Build all elements and add them to the components array.
	 *
	 * @param array &$components The components array to which elements will be added
	 */
	public function buildElements(array &$components) : void {
		foreach ($this->getElements() as $element) {
			$element->buildCheck();
			$element->build($components);
		}
	}
}
