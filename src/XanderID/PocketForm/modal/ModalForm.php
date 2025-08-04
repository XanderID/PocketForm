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

namespace XanderID\PocketForm\modal;

use pocketmine\lang\Translatable;
use XanderID\PocketForm\PocketForm;
use XanderID\PocketForm\traits\Body;
use XanderID\PocketForm\traits\Submit;
use XanderID\PocketForm\utils\Translate;

/**
 * Represents a modal form with two buttons (submit and cancel).
 *
 * @extends PocketForm<ModalFormResponse>
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
	 * @param string|Translatable $title  the title of the modal form
	 * @param string|Translatable $submit the text for the submit button (default is self::DEFAULT_SUBMIT)
	 * @param string|Translatable $cancel the text for the cancel button (default is self::DEFAULT_CANCEL)
	 */
	public function __construct(
		string|Translatable $title,
		string|Translatable $submit = self::DEFAULT_SUBMIT,
		string|Translatable $cancel = self::DEFAULT_CANCEL
	) {
		$this->setSubmit($submit);
		$this->setCancel($cancel);
		parent::__construct($title);
	}

	/**
	 * Creates a new ModalForm instance.
	 *
	 * @param string|Translatable $title  form title
	 * @param string|Translatable $body   form body (optional)
	 * @param string|Translatable $submit submit button text (optional, default is DEFAULT_SUBMIT)
	 * @param string|Translatable $cancel cancel button text (optional, default is DEFAULT_CANCEL)
	 */
	public static function create(
		string|Translatable $title,
		string|Translatable $body = '',
		string|Translatable $submit = self::DEFAULT_SUBMIT,
		string|Translatable $cancel = self::DEFAULT_CANCEL
	) : self {
		$form = new self($title, $submit, $cancel);
		$form->setBody($body);
		return $form;
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
	 * @return array<string, mixed> an associative array of components including body, submit, and cancel texts
	 */
	protected function initComponents() : array {
		return [
			'content' => Translate::translate($this->body),
			'button1' => Translate::translate($this->submit),
			'button2' => Translate::translate($this->cancel),
		];
	}
}
