<?php

namespace App\Controllers;

class Language extends Controller
{
	public function change($lang = DEFAULT_LANG, $referer = '')
	{
		if (!empty($referer)) $referer = base64_decode($referer);
		else $referer = '/';
		$this->auth();
		$_SESSION['lang'] = $lang;
		setcookie('lang', $lang);
		redirect($referer);
	}
}