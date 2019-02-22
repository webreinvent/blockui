<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    [
        'middleware' => [ 'web' ],
        'prefix'     => '/',
        'namespace'  => 'Modules\Blockui\Http\Controllers\Frontend'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/', 'PublicController@index' )
            ->name( 'bui.welcome' );
        //------------------------------------------------
        Route::any( 'blocks/list', 'PublicController@getBlocks' )
            ->name( 'bui.blocks.list' );
        //------------------------------------------------
        Route::any( 'block', 'PublicController@getBlock' )
            ->name( 'bui.block' );
        //------------------------------------------------
        //------------------------------------------------
        Route::get( 'block/create', 'PublicController@blockCreate' )
            ->name( 'bui.block.create' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });

