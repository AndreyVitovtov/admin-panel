<?php

namespace App\Controllers;

class Theme
{
	public function change($theme, $referer = '')
	{
		if (!empty($referer)) $referer = base64_decode($referer);
		else $referer = '/';
		setcookie('theme', $theme, time() + 315360000, '/');
		redirect($referer);
	}
}