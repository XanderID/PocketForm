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

namespace XanderID\PocketForm\custom\element;

use TypeError;
use XanderID\PocketForm\custom\CustomElement;
use XanderID\PocketForm\PocketFormException;
use XanderID\PocketForm\Utils;
use function array_map;

/**
 * Represents a step slider element with predefined step values.
 */
class StepSlider extends CustomElement {
	/**
	 * @param string    $label   the label for the step slider
	 * @param list<int> $step    an array of step values (each step is an integer)
	 * @param int|null  $default the default selected step index
	 */
	public function __construct(
		string $label,
		protected array $step,
		protected ?int $default = null
	) {
		$this->setLabel($label);
	}

	/**
	 * Get the step values.
	 *
	 * @return list<int> the array of step values
	 */
	public function getStep() : array {
		return $this->step;
	}

	/**
	 * Set the step values.
	 *
	 * @param list<int> $step the new array of step values
	 */
	public function setStep(array $step) : self {
		$this->step = $step;
		return $this;
	}

	/**
	 * Get the default step index.
	 *
	 * @return int|null the default selected index
	 */
	public function getDefault() : ?int {
		return $this->default;
	}

	/**
	 * Set the default step index.
	 *
	 * @param int $default the default index
	 */
	public function setDefault(int $default) : self {
		$this->default = $default;
		return $this;
	}

	/**
	 * Get the element type.
	 *
	 * @return string returns "step_slider"
	 */
	public function getType() : string {
		return 'step_slider';
	}

	/**
	 * Perform pre-build checks for the step slider.
	 *
	 * @throws PocketFormException if the default index is out of bounds
	 * @throws TypeError if the step array is not valid
	 */
	public function buildCheck() : void {
		if (Utils::validateArrayValueType($this->step, function (int $step) : void {})) {
			$this->buildError('Step Slider arrays can only be int');
		}

		$index = $this->default;
		if ($index !== null) {
			if (!isset($this->step[$index])) {
				$this->buildError('Cannot find Index ' . $index . ' on Step Slider');
			}
		}

		parent::buildCheck();
	}

	/**
	 * Build the step slider element.
	 *
	 * @param array<string, list<mixed>> &$components The components array to add the step slider to
	 */
	public function build(array &$components) : void {
		$steps = array_map('strval', $this->step);
		$slider = [
			'type' => $this->getType(),
			'text' => $this->label,
			'steps' => $steps,
		];
		if ($this->default !== null) {
			$slider['default'] = $this->default;
		}

		$components['content'][] = $slider;
	}
}
