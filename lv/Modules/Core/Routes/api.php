<?php

Route::group(
	[
		'middleware' => 'api',
        'prefix' => 'api',
        'namespace' => 'Modules\Core\Http\Controllers'
	],
	function()
	{
	    Route::get('/', 'CoreController@index');
	});
	//end of the group
