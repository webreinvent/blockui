<?php




Route::any( 'migration',
    'Modules\Core\Http\Controllers\CronController@migration' )
    ->name( 'core.migration' );



Route::any( 'core/ajax/uploader',
            'Modules\Core\Http\Controllers\CoreController@uploader' )
    ->name( 'core.frontend.ajax.uploader' );


Route::any( 'download/{encrypted_attachment_id}',
    'Modules\Core\Http\Controllers\CoreController@downloadFile' )
    ->name( 'core.download.file' );


/*
|--------------------------------------------------------------------------
| Clients Cron
|--------------------------------------------------------------------------
*/
Route::group(
    [
        'prefix'     => 'core/cron',
        'namespace'  => 'Modules\Core\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        //------------------------------------------------
        Route::get( '/per/minute', 'CronController@minute' )
            ->name( 'core.cron.minute' );
        //------------------------------------------------
        Route::get( '/per/hour', 'CronController@hour' )
            ->name( 'core.cron.hour' );
        //------------------------------------------------
        Route::get( '/per/day', 'CronController@day' )
            ->name( 'core.cron.day' );
        //------------------------------------------------

        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });



Route::group(
    [
        'middleware' => [ 'web', 'core.frontend' ],
        'namespace'  => 'Modules\Core\Http\Controllers'
    ],
    function () {
        Route::get( '/password/reset/{token}', 'AuthController@passwordReset' )
            ->name( 'core.frontend.password.reset' );
        //------------------------------------------------
        Route::any( '/password/reset/store', 'AuthController@postReset' )
            ->name( 'core.frontend.password.reset.store' );
        //------------------------------------------------
        Route::get('/clear/cache', function() {
            $response['data']['cache:clear'] =  \Artisan::call('cache:clear');
            $response['data']['view:clear'] =  \Artisan::call('view:clear');
            $response['data']['debugbar:clear'] =  \Artisan::call('debugbar:clear');
            $response['data']['route:clear'] =  \Artisan::call('route:clear');
            //$response['data'][] =  \Artisan::call('config:cache');


            $response['status'] = 'success';

            return response()->json($response);
        });
        //------------------------------------------------

    });

/*
|--------------------------------------------------------------------------
| Core Frontend Routes
|--------------------------------------------------------------------------
*/
Route::group(
	[
		'middleware' => [ 'web', 'core.frontend' ],
		'prefix'     => 'core',
		'namespace'  => 'Modules\Core\Http\Controllers'
	],
	function ()
    {
		Route::get( '/', 'UserController@login' )
		     ->name( 'core.frontend.login' )
		     ->middleware( [ 'core.frontend.login' ] );
		//------------------------------------------------
        Route::get( '/', 'UserController@login' )
            ->name( 'core.frontend.login' )
            ->middleware( [ 'core.frontend.login' ] );
		//------------------------------------------------
		Route::get( '/register', 'UserController@register' )
		     ->name( 'core.frontend.register' )
		     ->middleware( [ 'core.frontend.register' ] );
		//------------------------------------------------
        Route::get( '/login-by-url/{encrypted_user_id}', 'AuthController@loginByURL' )
            ->name( 'core.frontend.loginByUrl' );
		//------------------------------------------------
		Route::get( '/ui', 'CoreController@ui' )
		     ->name( 'core.frontend.ui' );
		//------------------------------------------------
        Route::get( '/test', 'CoreController@test' )
            ->name( 'core.frontend.test' );
		//------------------------------------------------

		//------------------------------------------------
		Route::get( '/doc', 'CoreController@doc' )
		     ->name( 'core.frontend.doc' );
		//------------------------------------------------
		Route::any( '/register/store', 'UserController@store' )
		     ->name( 'core.frontend.register.store' )
		     ->middleware( [ 'core.frontend.register' ] );
		//------------------------------------------------
		Route::any( '/authenticate', 'AuthController@login' )
		     ->name( 'core.frontend.authenticate' )
		     ->middleware( [ 'core.frontend.login' ] );
		//------------------------------------------------
		Route::any( '/modules/sync/db', 'CoreController@modulesSyncWithDb' )
		     ->name( 'core.backend.modules.sync' );
		//------------------------------------------------
		//------------------------------------------------
		Route::get( '/logout', 'AuthController@logout' )
		     ->name( 'core.backend.logout' )
		     ->middleware( [ 'core.backend' ] );
		//------------------------------------------------
        Route::any( '/email/templates/{name}', 'CoreController@emailTemplate' )
            ->name( 'core.backend.email.template' );
		//------------------------------------------------
        Route::any( '/file/upload', 'CoreController@fileUpload' )
            ->name( 'core.file.upload' );
		//------------------------------------------------
        Route::any( '/fileUploader', 'CoreController@fileUploader' )
            ->name( 'core.file.uploader' );
		//------------------------------------------------
        Route::any( '/image/cropping', 'CoreController@imageCropping' )
            ->name( 'core.image.cropping' );
		//------------------------------------------------
        Route::any( '/chat', 'CoreController@getChat' )
            ->name( 'core.chat' );
		//------------------------------------------------
        Route::any( '/chat/auth', 'CoreController@pusherAuth' )
            ->name( 'core.chat.auth' );
		//------------------------------------------------
        Route::any( '/chat/send', 'CoreController@sendMessage' )
            ->name( 'core.chat.send' );
		//------------------------------------------------
		//------------------------------------------------
	} );
/*
|--------------------------------------------------------------------------
| Core Backend Logout
|--------------------------------------------------------------------------
*/
Route::group(
	[
		'middleware' => [ 'web', 'core.backend' ],
		'prefix'     => 'backend/core',
		'namespace'  => 'Modules\Core\Http\Controllers'
	],
	function () {
		//------------------------------------------------
		Route::get( '/logout', 'AuthController@logout' )
		     ->name( 'core.backend.logout' );
		//------------------------------------------------
	} );
/*
|--------------------------------------------------------------------------
| Core Backend Routes
|--------------------------------------------------------------------------
*/
Route::group(
	[
		'middleware' => [ 'web', 'core.backend' ],
		'prefix'     => 'backend/core',
		'namespace'  => 'Modules\Core\Http\Controllers'
	],
	function () {
		Route::get( '/dashboard', 'DashboardController@index' )
		     ->name( 'core.backend.dashboard' );
		//############# Permission #################################
		Route::get( '/permissions', 'PermissionsController@index' )
		     ->name( 'core.backend.permissions' );
		//------------------------------------------------
		Route::get( '/permissions/list', 'PermissionsController@getList' )
		     ->name( 'core.backend.permissions.list' );
		//------------------------------------------------
		Route::post( '/permissions/toggle', 'PermissionsController@toggle' )
		     ->name( 'core.backend.permissions.toggle' );
		//------------------------------------------------
		Route::any( '/permissions/read/{id}', 'PermissionsController@read' )
		     ->name( 'core.backend.permissions.read' );
		//############# Role #################################
		//------------------------------------------------
		Route::get( '/roles', 'RolesController@index' )
		     ->name( 'core.backend.roles' );
		//------------------------------------------------
		Route::get( '/roles/list', 'RolesController@getList' )
		     ->name( 'core.backend.roles.list' );
		//------------------------------------------------
		Route::any( '/roles/toggle', 'RolesController@toggle' )
		     ->name( 'core.backend.roles.toggle' );
		//------------------------------------------------
		Route::post( '/roles/store', 'RolesController@store' )
		     ->name( 'core.backend.roles.store' );
		//------------------------------------------------
		Route::any( '/roles/delete/{id}', 'RolesController@delete' )
		     ->name( 'core.backend.roles.delete' );
		//------------------------------------------------
		Route::any( '/roles/restore/{id}', 'RolesController@restore' )
		     ->name( 'core.backend.roles.restore' );
		//------------------------------------------------
		Route::any( '/roles/delete/permanent/{id}', 'RolesController@deletePermanent' )
		     ->name( 'core.backend.roles.delete.permanent' );
		//------------------------------------------------
		Route::any( '/roles/read/{id}', 'RolesController@read' )
		     ->name( 'core.backend.roles.read' );
		//------------------------------------------------
		Route::any( '/roles/read/{id}/details', 'RolesController@readDetails' )
		     ->name( 'core.backend.roles.read.details' );
		//------------------------------------------------
		Route::post( '/roles/update', 'RolesController@update' )
		     ->name( 'core.backend.roles.update' );
		//------------------------------------------------
		Route::any( '/roles/read/{id}/stats', 'RolesController@stats' )
		     ->name( 'core.backend.roles.stats' );
		//------------------------------------------------
		Route::any( '/roles/read/{id}/permissions', 'RolesController@permissions' )
		     ->name( 'core.backend.roles.permissions' );
		//------------------------------------------------
		Route::any( '/roles/read/{id}/permissions/toggle/{permission_id}',
			'RolesController@permissionsToggle' )
		     ->name( 'core.backend.roles.permissions.toggle' );
		//------------------------------------------------


		//############# Users CRUD #################################
		Route::get( '/users', 'UsersController@index' )
		     ->name( 'core.backend.users' );
		//------------------------------------------------
		Route::get( '/users/list', 'UsersController@getList' )
		     ->name( 'core.backend.users.list' );
		//------------------------------------------------
		Route::any( '/users/store', 'UsersController@store' )
		     ->name( 'core.backend.users.store' );
		//------------------------------------------------
        Route::any( '/users/enable/{id}', 'UsersController@enable' )
            ->name( 'core.backend.users.enable' );
		//------------------------------------------------
        Route::any( '/users/disable/{id}', 'UsersController@disable' )
            ->name( 'core.backend.users.disable' );
		//------------------------------------------------
        Route::any( '/users/delete/{id}', 'UsersController@delete' )
            ->name( 'core.backend.users.delete' );
		//------------------------------------------------
        Route::any( '/users/edit/{id}', 'UsersController@edit' )
            ->name( 'core.backend.users.edit' );
		//------------------------------------------------
        Route::any( '/users/update/{id}', 'UsersController@update' )
            ->name( 'core.backend.users.update' );
		//------------------------------------------------
        Route::any( '/users/restore/{id}', 'UsersController@restore' )
            ->name( 'core.backend.users.restore' );
        //------------------------------------------------
        Route::any( '/users/permanent/delete/{id}', 'UsersController@permanentDelete' )
            ->name( 'core.backend.users.permanent.delete' );
		//------------------------------------------------
        Route::any( '/users/{id}', 'UsersController@view' )
            ->name( 'core.backend.users.view' );
		//------------------------------------------------

        //############# User Profile #################################
        Route::any( '/profile/{id?}', 'ProfileController@index' )
            ->name( 'core.backend.user.profile' );
		//------------------------------------------------
        Route::any( '/profile-data/{id?}', 'ProfileController@getProfileData' )
            ->name( 'core.backend.user.profile.data' );
		//------------------------------------------------
        Route::any( '/profile-update', 'ProfileController@updateProfile' )
            ->name( 'core.backend.user.update' );
		//------------------------------------------------
        Route::any( '/profile-activities', 'ProfileController@profileActivities' )
            ->name( 'core.backend.user.activities' );
		//------------------------------------------------



		//------------------------------------------------
        Route::any( '/media/get', 'CoreController@chooseMedia' )
            ->name( 'core.media.get' );
		//------------------------------------------------
        Route::any( '/media/store', 'CoreController@storeMedia' )
            ->name( 'core.media.store' );
		//------------------------------------------------
        Route::any( '/media/delete', 'CoreController@deleteMedia' )
            ->name( 'core.media.delete' );
		//------------------------------------------------
		//------------------------------------------------
		//------------------------------------------------
		//------------------------------------------------

	} );


/*
|--------------------------------------------------------------------------
| Core Backend Logout
|--------------------------------------------------------------------------
*/
Route::group(
    [
        'middleware' => [ 'web' ],
        'prefix'     => '/v2',
        'namespace'  => 'Modules\Core\Http\Controllers\V2\Frontend'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/ui', 'PublicController@ui' )
            ->name( 'core.v2.ui' );
        //------------------------------------------------
        //------------------------------------------------
        Route::get( '/login', 'PublicController@login' )
            ->name( 'core.v2.login' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });

