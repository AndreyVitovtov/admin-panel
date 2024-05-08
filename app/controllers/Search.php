<?php

namespace App\Controllers;

use App\Core\Request;

class Search extends Controller
{
	public function index(Request $request)
	{
		$this->auth()->view('index', [
			'title' => 'Search',
			'pageTitle' => 'Searching results: "' . $request->search . '"'
		]);
	}
}