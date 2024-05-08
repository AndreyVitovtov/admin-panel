<?php

namespace App\Controllers;

class Main extends Controller
{
	public function __construct()
	{
//		$this->forbid = [
//			'guest' => 'ALL'
//		];
	}

	public function index(): void
	{
		$this->auth()->view('dashboard', [
			'title' => __('dashboard'),
			'pageTitle' => __('dashboard'),
			'assets' => [
				'js' => 'chart.umd.min.js'
			]
		]);
	}
}