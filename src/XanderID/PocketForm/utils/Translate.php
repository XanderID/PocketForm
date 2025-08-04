<?php

declare(strict_types=1);

namespace XanderID\PocketForm\utils;

use pocketmine\lang\Translatable;

/**
 * Utility class for translating Translatable objects into rawtext format.
 */
class Translate {
	/**
	 * Converts a string or Translatable into a rawtext-compatible array or a plain string.
	 *
	 * @param string|Translatable $text the text to convert
	 *
	 * @return array<string, mixed>|string the rawtext array if translatable, or the plain string
	 */
	public static function translate(string|Translatable $text) : array|string {
		if ($text instanceof Translatable) {
			$build = function (Translatable $t) use (&$build) : array {
				$params = [];
				foreach ($t->getParameters() as $param) {
					$params[] = $param instanceof Translatable
						? $build($param)
						: ['text' => (string) $param];
				}

				$result = ['translate' => $t->getText()];
				if ($params !== []) {
					$result['with'] = ['rawtext' => $params];
				}

				return $result;
			};

			return ['rawtext' => [$build($text)]];
		}

		return (string) $text;
	}
}
