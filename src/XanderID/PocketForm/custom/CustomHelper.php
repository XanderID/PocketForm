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

use pocketmine\lang\Translatable;
use XanderID\PocketForm\custom\element\Dropdown;
use XanderID\PocketForm\custom\element\Input;
use XanderID\PocketForm\custom\element\Slider;
use XanderID\PocketForm\custom\element\StepSlider;
use XanderID\PocketForm\custom\element\Toggle;
use XanderID\PocketForm\element\Divider;
use XanderID\PocketForm\element\Header;
use XanderID\PocketForm\element\Label;

/**
 * Provides helper methods to add various custom elements to a form.
 */
trait CustomHelper {
	/**
	 * Add a dropdown element.
	 *
	 * @param string|Translatable       $label   the label for the dropdown
	 * @param list<string|Translatable> $options an array of options for the dropdown
	 * @param int|null                  $default the default selected index
	 * @param string|Translatable|null  $tooltip tooltip shown on hover (optional)
	 */
	public function addDropdown(string|Translatable $label, array $options, ?int $default = null, null|string|Translatable $tooltip = null) : static {
		$dropdown = new Dropdown($label, $options, $default, $tooltip);
		$this->addElement($dropdown);
		return $this;
	}

	/**
	 * Add an input element.
	 *
	 * @param string|Translatable      $label       the label for the input
	 * @param string|Translatable      $placeholder the placeholder text
	 * @param string|null              $default     the default input value
	 * @param string|Translatable|null $tooltip     tooltip shown on hover (optional)
	 */
	public function addInput(string|Translatable $label, string|Translatable $placeholder = '', ?string $default = null, null|string|Translatable $tooltip = null) : static {
		$input = new Input($label, $placeholder, $default, $tooltip);
		$this->addElement($input);
		return $this;
	}

	/**
	 * Add a label element.
	 *
	 * @param string|Translatable $label the text for the label element
	 */
	public function addLabel(string|Translatable $label) : static {
		$labelElement = new Label($label);
		$this->addElement($labelElement);
		return $this;
	}

	/**
	 * Add a slider element.
	 *
	 * @param string|Translatable      $label   the label for the slider
	 * @param int                      $min     the minimum slider value
	 * @param int                      $max     the maximum slider value
	 * @param int|null                 $step    the slider step increment
	 * @param int|null                 $default the default slider value
	 * @param string|Translatable|null $tooltip tooltip shown on hover (optional)
	 */
	public function addSlider(string|Translatable $label, int $min, int $max, ?int $step = null, ?int $default = null, null|string|Translatable $tooltip = null) : static {
		$slider = new Slider($label, $min, $max, $step, $default, $tooltip);
		$this->addElement($slider);
		return $this;
	}

	/**
	 * Add a step slider element.
	 *
	 * @param string|Translatable      $label   the label for the step slider
	 * @param list<int>                $step    an array of step values
	 * @param int|null                 $default the default selected step index
	 * @param string|Translatable|null $tooltip tooltip shown on hover (optional)
	 */
	public function addStepSlider(string|Translatable $label, array $step, ?int $default = null, null|string|Translatable $tooltip = null) : static {
		$stepSlider = new StepSlider($label, $step, $default, $tooltip);
		$this->addElement($stepSlider);
		return $this;
	}

	/**
	 * Add a toggle element.
	 *
	 * @param string|Translatable      $label   the label for the toggle
	 * @param bool|null                $default the default toggle state
	 * @param string|Translatable|null $tooltip tooltip shown on hover (optional)
	 */
	public function addToggle(string|Translatable $label, ?bool $default = null, null|string|Translatable $tooltip = null) : static {
		$toggle = new Toggle($label, $default, $tooltip);
		$this->addElement($toggle);
		return $this;
	}

	/**
	 * Add a header element.
	 *
	 * This is a non-interactive element used for labeling sections.
	 * WARNING: Only supported in Minecraft version 1.21.70 and above.
	 *
	 * @param string|Translatable $text the text to display in the header
	 *
	 * @return $this
	 */
	public function addHeader(string|Translatable $text) : static {
		$header = new Header($text);
		$this->addElement($header);
		return $this;
	}

	/**
	 * Add a divider element.
	 *
	 * This is a non-interactive horizontal line used to separate sections.
	 * WARNING: Only supported in Minecraft version 1.21.70 and above.
	 *
	 * @return $this
	 */
	public function addDivider() : static {
		$divider = new Divider();
		$this->addElement($divider);
		return $this;
	}
}
