<?php

namespace App\Models;

class AdminModel extends Model
{
	protected $table = 'admins';
	protected $fields = [
		'name', 'login', 'password', 'avatar', 'role'
	];
}