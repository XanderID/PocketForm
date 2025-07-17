<?php

declare(strict_types=1);

namespace XanderID\PocketForm\utils;

use Exception;
use XanderID\PocketForm\Utils;
use function array_map;
use function file_exists;
use function file_get_contents;
use function implode;
use function json_decode;
use function json_last_error;
use function json_last_error_msg;
use function preg_match;
use function strlen;
use function strtoupper;
use function usort;
use const JSON_ERROR_NONE;

/**
 * Singleton class for accessing country phone code data from JSON.
 */
class CountryPhones {
	/** @var CountryPhones|null Singleton instance */
	private static ?CountryPhones $instance = null;

	/** @var array<int, array{country: string, code: string, iso: string}> List of countries with phone codes and ISO codes */
	private array $countries;

	/**
	 * CountryPhones constructor.
	 *
	 * @throws Exception If the JSON file is not found or invalid
	 */
	private function __construct() {
		$basePath = Utils::getResourcePath();
		$jsonPath = $basePath . '/resources/phoneCountryCodes.json';

		if (!file_exists($jsonPath)) {
			throw new Exception("JSON file not found: {$jsonPath}");
		}

		$json = file_get_contents($jsonPath);
		if ($json === false) {
			throw new Exception("Failed to read JSON file: {$jsonPath}");
		}

		$data = json_decode($json, true);
		if (json_last_error() !== JSON_ERROR_NONE) {
			throw new Exception('JSON decode error: ' . json_last_error_msg());
		}

		/** @var array<int, array{country: string, code: string, iso: string}> $data */
		$this->countries = $data;
	}

	/**
	 * Returns the singleton instance of CountryPhones.
	 */
	public static function getInstance() : self {
		if (self::$instance === null) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Get all country phone data.
	 *
	 * @return array<int, array{country: string, code: string, iso: string}>
	 */
	public function getAll() : array {
		return $this->countries;
	}

	/**
	 * Find a country by its ISO 2-letter code.
	 *
	 * @param string $iso ISO 3166-1 alpha-2 code (e.g., "ID", "US")
	 *
	 * @return array{country: string, code: string, iso: string}|null
	 */
	public function findByIso(string $iso) : ?array {
		foreach ($this->countries as $country) {
			if (strtoupper($country['iso']) === strtoupper($iso)) {
				return $country;
			}
		}

		return null;
	}

	/**
	 * Find a country by its phone dialing code.
	 *
	 * @param string $code Phone code string (e.g., "62", "1")
	 *
	 * @return array{country: string, code: string, iso: string}|null
	 */
	public function findByCode(string $code) : ?array {
		foreach ($this->countries as $country) {
			if ($country['code'] === $code) {
				return $country;
			}
		}

		return null;
	}

	/**
	 * Validate and extract country info from a phone number.
	 *
	 * Examples:
	 *  - "+628123456789" matches code "62"
	 *  - "628123456789" invalid if $requirePlusSign = true
	 *
	 * @param string $phone               Phone number to validate
	 * @param bool   $requirePlusSign     Require '+' at the beginning (default: false)
	 * @param bool   $validateCountryCode Restrict to valid known country codes only (default: true)
	 *
	 * @return array{country: string, code: string, iso: string}|null
	 */
	public function validatePhone(string $phone, bool $requirePlusSign = false, bool $validateCountryCode = true) : ?array {
		$prefix = $requirePlusSign ? '\\+' : '\\+?';

		$codes = array_map(fn ($c) => $c['code'], $this->countries);
		usort($codes, fn ($a, $b) => strlen($b) <=> strlen($a));

		$codePattern = $validateCountryCode
			? '(' . implode('|', $codes) . ')'
			: '\\d{1,4}';

		$pattern = '/^' . $prefix . $codePattern . '\\d{4,15}$/';
		if (!preg_match($pattern, $phone, $matches)) {
			return null;
		}

		$matchedCode = $matches[1] ?? null;
		if ($matchedCode === null) {
			return null;
		}

		return $this->findByCode($matchedCode);
	}
}
