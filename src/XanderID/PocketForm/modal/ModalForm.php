<?php

declare(strict_types=1);

namespace XanderID\PocketForm\modal;

use XanderID\PocketForm\PocketForm;
use XanderID\PocketForm\traits\Body;
use XanderID\PocketForm\traits\Submit;

/**
 * Represents a modal form with two buttons (submit and cancel).
 */
class ModalForm extends PocketForm {
	use Body;
	use Submit;

	/**
	 * Default submit text.
	 *
	 * @var string
	 */
	public const DEFAULT_SUBMIT = 'gui.yes';

	/**
	 * Default cancel text.
	 *
	 * @var string
	 */
	public const DEFAULT_CANCEL = 'gui.no';

	/**
	 * @param string $title the title of the modal form
	 */
	public function __construct(string $title) {
		$this->setSubmit(self::DEFAULT_SUBMIT);
		$this->setCancel(self::DEFAULT_CANCEL);
		parent::__construct($title);
	}

	/**
	 * Get the form type.
	 *
	 * @return string returns "modal"
	 */
	protected function getType() : string {
		return 'modal';
	}

	/**
	 * Get the response class name.
	 *
	 * @return string returns the class name for modal form responses
	 */
	protected function getResponseClass() : string {
		return ModalFormResponse::class;
	}

	/**
	 * Get the callback signature for modal form responses.
	 *
	 * @return callable the expected signature for the onResponse callback
	 */
	protected function getSignature() : callable {
		return function (ModalFormResponse $response) : void {};
	}

	/**
	 * Initialize modal form components.
	 *
	 * @return array an associative array of components including body, submit, and cancel texts
	 */
	protected function initComponents() : array {
		return [
			'content' => $this->body,
			'button1' => $this->submit,
			'button2' => $this->cancel,
		];
	}
}
