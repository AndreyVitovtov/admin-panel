<?php

namespace App\Controllers;

class Errors extends Controller
{
	public function error404(): void
	{
		$this->view('404', [
			'title' => 'Page Not Found',
			'pageTitle' => '404'
		]);
	}

	public function error403()
	{
		$this->view('403', [
			'title' => 'Access denied',
			'pageTitle' => '403'
		]);
	}
}