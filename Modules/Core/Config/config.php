<?php

$config = array();

$path = __DIR__."/../module.json";
if (File::exists($path)) {
	$file = File::get($path);
	$module_config = json_decode($file);
	$config = (array)$module_config;
}

return $config;
