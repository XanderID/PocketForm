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

namespace XanderID\PocketForm\traits;

use pocketmine\lang\Translatable;
use XanderID\PocketForm\modal\ModalForm;

/**
 * Provides functionality to attach a confirmation form to a form element.
 */
trait Confirm {
	/** @var ModalForm|null the confirmation form */
	protected ?ModalForm $confirmForm = null;

	/**
	 * Set up a confirmation form.
	 *
	 * @param string|Translatable $title  the title of the confirmation form
	 * @param string|Translatable $body   the body content of the confirmation form
	 * @param string|Translatable $submit the submit button text (default is ModalForm::DEFAULT_SUBMIT)
	 * @param string|Translatable $cancel the cancel button text (default is ModalForm::DEFAULT_CANCEL)
	 */
	public function confirm(string|Translatable $title, string|Translatable $body, string|Translatable $submit = ModalForm::DEFAULT_SUBMIT, string|Translatable $cancel = ModalForm::DEFAULT_CANCEL) : static {
		$form = new ModalForm($title);
		$form->setBody($body);
		$form->setSubmit($submit);
		$form->setCancel($cancel);
		$this->confirmForm = $form;
		return $this;
	}

	/**
	 * Get the confirmation form.
	 *
	 * @return ModalForm|null the attached confirmation form, or null if not set
	 */
	public function getConfirm() : ?ModalForm {
		return $this->confirmForm;
	}
}
