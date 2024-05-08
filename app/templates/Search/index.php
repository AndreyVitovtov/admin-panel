<?php
global $menu;
echo implode('<br>', array_map(function ($v) {
	return $v['title'];
}, $menu));