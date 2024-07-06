<?php

namespace App\Utility;

class Request
{
	public static function get($param = null, $alter = null)
	{
		if (isset($_REQUEST)) {
			if (!empty($param)) {
				return $_REQUEST[$param] ?? $alter;
			}
			return $_REQUEST;
		}
		return [];
	}

	public function __get($name)
	{
		return empty($_REQUEST[$name]) ? null : $_REQUEST[$name];
	}
}