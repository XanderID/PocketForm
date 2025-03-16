<?php

declare(strict_types=1);

namespace XanderID\PocketForm\traits;

/**
 * Provides methods to set and get the body content for simple and modal forms.
 */
trait Body {
	/** @var string the body content */
	protected string $body = '';

	/**
	 * Set the body content.
	 *
	 * @param string $body the content to set
	 */
	public function setBody(string $body) : self {
		$this->body = $body;
		return $this;
	}

	/**
	 * Get the body content.
	 *
	 * @return string the current body content
	 */
	public function getBody() : string {
		return $this->body;
	}
}
