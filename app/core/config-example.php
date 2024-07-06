<?php

const DEV = true;

const BASE_URL = 'https://sitename.com';
const DEFAULT_LANG = 'en';
const TIMEZONE = 'Europe/Kiev';


/* DATABASE */
const DB_HOST = 'localhost';
const DB_PORT = '3306';
const DB_NAME = 'admin-panel';
const DB_USERNAME = '';
const DB_PASSWORD = '';

const LANGUAGES = [
	// To add localization, add the language pack to app/data/lang/abbr.json
	'en' => [
		'title' => 'English',
		'image' => 'en.png',
		'abbr' => 'en'
	],
	'ua' => [
		'title' => 'Ukrainian',
		'image' => 'ua.png',
		'abbr' => 'ua',
	]
];

const EXTENSIONS_AVATAR = ['jpeg', 'jpg', 'png'];
const MAX_SIZE_AVATAR = 5; // 5mb

const PROJECT_NAME = 'Admin panel';
const VERSION = 'version: 1.0';

const CIPHER = '1234567890';
