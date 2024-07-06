<?php

namespace App\Controllers;

class Controller
{

	/* EXAMPLE
			$this->access = [
				'guest' => [
					'index'
				],
				'admin' => [
					'index'
				]
			];

		  $this->forbid = [
			  'guest' => 'ALL'
		  ];
	*/

	protected $access = [];
	protected $forbid = [];

	protected function view($template, $params = []): Controller
	{
		if (!empty($this->auth) || !empty($this->access) || !empty($this->forbid)) {
			$trace = debug_backtrace();
			$method = $trace[1]['function'] ?? null;
			if (!empty($this->access) || !empty($this->forbid)) {
				if (!is_null($method)) {
					$this->checkAccess($method);
				}
			}

			if (!empty($this->auth)) {
				if (!is_null($method) && in_array($method, $this->auth)) {
					$this->checkAuth();
				}
			}
		}

		$params['template'] = strtolower(array_reverse(preg_split('/[\/\\\\]/', get_called_class()))[0]) . '/' .
			$template;
		$params['theme'] = theme();
		extract(getSessionParams());
		extract($params);
		$template = ucfirst($template);
		require_once 'app/templates/main.php';
		return $this;
	}

	protected function checkAuth()
	{
		if (!isAuth()) {
			(new Errors)->error403();
		}
	}

	protected function checkAccess($method)
	{
		if (!empty($this->access) && !in_array($method, $this->access[getRole()] ?? [])) {
			(new Errors)->error403();
			die;
		}

		if (isset($this->forbid[getRole()]) &&
			(is_string($this->forbid[getRole()]) && strtoupper($this->forbid[getRole()]) == 'ALL') ||
			(in_array($method, $this->forbid[getRole()] ?? []))) (new Errors)->error403();
	}

	protected function auth(): ?Controller
	{
		if (isAuth()) return $this;
		redirect('/auth');
		return null;
	}

	protected function notAuth(): ?Controller
	{
		if (!isAuth()) return $this;
		redirect('/');
		return null;
	}
}