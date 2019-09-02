<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Modules\Core\Entities\Notifications;

class CronController extends Controller
{
    //------------------------------------------------------
    function __construct( Request $request )
    {

    }
    //------------------------------------------------------
    public function minute(Request $request)
    {

        $response = [];
        $response['sendEmailNotifications'] = Notifications::sendEmailNotifications();
        $response['oneSignalPushNotifications'] = Notifications::sendOneSignalPushNotifications();
        return response()->json($response);
    }
    //------------------------------------------------------
    public function hour(Request $request)
    {
        $response = [];
        return response()->json($response);
    }
    //--------------------------------------------------------
    public function day(Request $request)
    {
        $response = [];
        return response()->json($response);
    }
    //--------------------------------------------------------
    public function migration(Request $request)
    {

        //die("permission denied");



        $rules = array(
            'command' => 'required',
            'module' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            $response['commands'] = [
                'module:migrate-refresh',
                'module:migrate',
                'module:migrate-reset',
                'module:make-seed',
                'module:seed',
                'module:publish-migration',
                'module:publish-translation',
                'module:setup',
                'module:update',
                'module:make-job',
                'module:make-mail',
                'module:make-notification',
                'module:publish-config',
                'module:make-request',
                'module:use',
                'module:dump',
                'module:publish',
                'module:migrate-rollback',
                'module:make-event',
                'module:make-listener',
                'module:enable',
                'module:disable',
                'module:make-command',
                'module:make-controller',
                'module:make-middleware',
                'module:make-provider',
                'module:make',
                'module:make-migration',
                'module:list',
                'module:install',
                'module:route-provider',
                'module:make-model',
            ];
            $response['parameters'] = [
                'command',
                'module',
                '--force',
            ];

            return response()->json($response);
        }


        try
        {

            $params = $request->except(['command']);

            \Artisan::call($request->get('command'), $params);

            dd(\Artisan::output());
        }
        catch(\Exception $e) {
            return response()->json($e);
        }



    }
    //--------------------------------------------------------
}
