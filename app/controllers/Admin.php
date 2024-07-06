<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Utility\Request;

class Admin extends Controller
{
	public function settings()
	{
		$this->auth()->view('settings', [
			'title' => __('settings'),
			'pageTitle' => __('settings')
		]);
	}

	public function save(Request $request)
	{
		$admin = new AdminModel();
		if ($request->login != user('login') && !empty($admin->get([
				'login' => $request->login
			]))) {
			redirect('/admin/settings', [
				'error' => __('administrator with this login already exists')
			]);
		} else {
			$admin->find(user('id'));
			$admin->name = $request->name;
			$admin->login = $request->login;

			if (!is_null($request->password)) {
				if (is_null($request->repeatPassword)) {
					redirect('/admin/settings', [
						'error' => __('send all required parameters')
					]);
					exit;
				} else {
					if ($request->password == $request->repeatPassword) {
						$admin->password = md5($request->password);
					} else {
						redirect('/admin/settings', [
							'error' => __('password mismatch')
						]);
						exit;
					}
				}
			}

			if (!empty($_FILES['avatar']['name'])) {
				$errors = [];
				$fileName = $_FILES['avatar']['name'];
				$fileSize = $_FILES['avatar']['size'];
				$fileTmp = $_FILES['avatar']['tmp_name'];
				$fileExt = explode('.', $fileName);
				$fileExt = strtolower(end($fileExt));
				$fileName = md5(user('id') . time()) . '.' . $fileExt;
				$extensions = EXTENSIONS_AVATAR;

				if (in_array($fileExt, $extensions) === false) {
					redirect('/admin/settings', [
						'error' => __('extension not allowed', [
							'extensions' => implode(', ', EXTENSIONS_AVATAR)
						])
					]);
					exit;
				}

				if ($fileSize > (MAX_SIZE_AVATAR * 1024 * 1024)) {
					redirect('/admin/settings', [
						'error' => __('file size must be less', [
							'mb' => MAX_SIZE_AVATAR
						])
					]);
					exit;
				}

				if (empty($errors)) {
					if (move_uploaded_file($fileTmp, 'app/assets/images/avatars/' . $fileName)) {
						if (!empty(user('avatar'))) {
							unlink('app/assets/images/avatars/' . user('avatar'));
						}
						$admin->avatar = $fileName;
					} else {
						redirect('/admin/settings', [
							'error' => __('failed to upload file')
						]);
						exit;
					}
				} else {
					redirect('/admin/settings', [
						'error' => $errors
					]);
					exit;
				}
			}

			$admin->update();
			sessionUpdate([
				'login' => $admin->login,
				'name' => $admin->name,
				'avatar' => $admin->avatar
			]);
			redirect('/admin/settings', [
				'message' => __('changes saved')
			]);
		}
	}
}