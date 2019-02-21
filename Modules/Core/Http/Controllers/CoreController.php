<?php

namespace Modules\Core\Http\Controllers;

use App\Events\HelloPusherEvent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Entities\Attachment;
use Modules\Core\Entities\Media;
use Modules\Core\Entities\MediasRelationship;
use Modules\Core\Entities\Module;
use Modules\Core\Entities\User;
use Modules\Core\Libraries\CoreOneSignal;

class CoreController extends Controller
{

	//--------------------------------------------------------
    function fileUpload()
    {
        return view( 'core::frontend.file-upload' );
    }
	//--------------------------------------------------------
    public function fileUploader(Request $request)
    {
        error_reporting(E_ALL | E_STRICT);
        new \Modules\Core\Http\Controllers\UploadController();
        //return response()->json($response);

    }
	//--------------------------------------------------------
    public function uploader(Request $request)
    {



        if ($_FILES['file']['name']) {
            if (!$_FILES['file']['error']) {
                $name = md5(rand(100, 200));
                $ext = explode('.', $_FILES['file']['name']);
                $filename = $name .'-'.uniqid().'.' . $ext[1];
                $destination = 'files/' . $filename; //change this directory
                $location = $_FILES["file"]["tmp_name"];
                move_uploaded_file($location, $destination);

                echo \URL::to("/").'/files/' . $filename;//change this URL

            }
            else
            {
                echo  $message = 'Ooops!  Your upload triggered the following error:  '.json_encode($_FILES['file']['error']);
            }


        }
    }
	//--------------------------------------------------------
	public function modulesSyncWithDb()
	{
		try{
			$list = \NwidartModule::all();
			$list = (array)json_decode(json_encode($list));
			if(is_array($list) && count($list) >0)
			{
				foreach ($list as $module_name => $item)
				{
					$path = base_path()."/Modules/".$module_name."/module.json";
					if (\File::exists($path))
					{
						$file = \File::get($path);
						$module_config = json_decode($file);
						$config = (array)$module_config;

						$module = Module::firstOrNew(['slug' => $config['alias']]);
						$module->name = $config['name'];
						$module->slug = $config['alias'];
						if(isset($config['version']))
						{
							$parse_version = explode(".",$config['version']);
							if(isset($parse_version[0]))
							{
								$module->version_major = $parse_version[0];
							}
							if(isset($parse_version[1]))
							{
								$module->version_minor = $parse_version[1];
							}

							if(isset($parse_version[2]))
							{
								$module->version_revision = $parse_version[2];
							}

							if(isset($parse_version[3]))
							{
								$module->version_build = $parse_version[3];
							}
						}

						if(isset($config['description']))
						{
							$module->details = $config['description'];
						}

						$module->meta = json_encode($config);
						if(isset($config['active']))
						{
							$module->enable = $config['active'];
						}
						$module->save();
					}
				}
			}
			$response['status'] = 'success';

		}catch(Exception $e)
		{
		    $response['status'] = 'failed';
		    $response['errors'][] = $e->getMessage();
		}

		return response()->json( $response );

	}
	//--------------------------------------------------------
	public function ui()
	{
		return view( 'core::frontend.ui' );
	}
	//--------------------------------------------------------
	public function doc()
	{
		return view( 'core::frontend.doc' );
	}
	//--------------------------------------------------------
    public function test()
    {


        //----------------send push notification to PM
        $user_ids = User::getByRolesOnlyIds(['trusted', 'pm', 'admin']);
        $user_ids = array_unique(array_filter($user_ids));

        echo "<pre>";
        print_r($user_ids);
        echo "</pre>";

        $title = \Auth::user()->name." has started the timer.";
        $content = \Auth::user()->name." Task: #";
        $link = "";

        CoreOneSignal::sendNotificationUsers($user_ids, $title, $content, $link);
        //----------------send push notification to PM

        die("<hr/>line number=123");

        return view( 'core::frontend.test' );
    }
	//--------------------------------------------------------
    public function emailTemplate($name)
    {
        return view( 'core::emails.'.$name );
    }
	//--------------------------------------------------------

    public function imageCropping()
    {
        return view( 'core::frontend.image-cropping' );
    }

	//--------------------------------------------------------
	//--------------------------------------------------------
	//--------------------------------------------------------
    public function getChat()
    {





        $data = [
            'key' => env('PUSHER_KEY'),
            'secrete' => env('PUSHER_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'cluster' => env('PUSHER_APP_CLUSTER'),
        ];

        return view( 'core::frontend.chat')->with('data', $data);
    }
	//--------------------------------------------------------
    public function pusherAuth(Request $request)
    {
        $pusher = new \Pusher( env('PUSHER_KEY'), env('PUSHER_SECRET'), env('PUSHER_APP_ID') );
        echo $pusher->presence_auth($request->get('channel_name'), $request->get('socket_id'), 1);

        /*$pusher = new \Pusher( '3ee8efc1b5ea9de4411b', 'dd4060a89d36498c3920', '321737' );
        echo $pusher->presence_auth($request->get('channel_name'), $request->get('socket_id'), 1);*/

    }
	//--------------------------------------------------------
    public function sendMessage(Request $request)
    {

        \OneSignal::sendNotificationToUser("Some Message", $request->get('onsignal_user_id'),  $url = null, $data = null, $buttons = null, $schedule = null);


        event(new HelloPusherEvent($request->all()));

        $response['status'] = 'success';
        $response['data'] = 'success';

        return response()->json($response);

    }
	//--------------------------------------------------------
    public function chooseMedia(Request $request)
    {

        $list = Media::select('id', 'name', 'thumbnail_url', 'url');

        if($request->has('q'))
        {
            $list->where(function ($query) use ($request){
                $query->where('name', 'LIKE', '%'.$request->get('q').'%')
                    ->orWhere('url', 'LIKE', '%'.$request->get('q').'%');
            });
        }

        $response['status'] = 'success';
        $response['data'] = $list->orderBy('created_at', 'DESC')->paginate(15);

        return response()->json($response);

    }
	//--------------------------------------------------------
    public function storeMedia(Request $request)
    {
        $inputs = $request->all();

        $messages = [];
        $data = [];
        if($inputs)
        {
            $i = 0;
            foreach ($inputs as $input)
            {
                $media = Media::where('url', $input['url'])->first();

                if($media)
                {
                    $messages[$i] = $i." medias are duplicated";
                    $i++;
                    continue;
                } else
                {
                    $media = new Media();
                    $media->name = $input['name'];
                    $media->thumbnail_url = $input['thumbnailUrl'];
                    $media->url = $input['url'];
                    $media->ext = $input['type'];
                    $media->created_by = \Auth::user()->id;
                    $media->save();
                }

                $data[$i] = $media;

                $i++;
            }
        }

        $response['status'] = 'success';
        $response['data'] = $data;
        $response['messages'] = $messages;

        return response()->json($response);

    }
	//--------------------------------------------------------
    public function deleteMedia(Request $request)
    {






        $response = null;
        $rules = array(
            'id' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $media = Media::find($request->id);

        if(!$media)
        {
            $response['status'] = 'failed';
            $response['errors'][]= "Not Exist";
            return response()->json($response);
        }

        $base_url = \URL::to("/");
        $file_path = str_replace($base_url, "", $media->url);
        $file_path = public_path('..'.$file_path);
        $file_thumbnail = str_replace($base_url, "", $media->thumbnail_url);
        $file_thumbnail = public_path('..'.$file_thumbnail);



        \File::delete($file_path);
        \File::delete($file_thumbnail);

        //delete relationships
        MediasRelationship::where('core_media_id', $media->id)->forceDelete();

        $media->forceDelete();

        $response['status'] = 'success';

        return response()->json($response);
    }
	//--------------------------------------------------------
    public function downloadFile(Request $request, $encrypted_attachment_id)
    {

        $id = \Crypt::decrypt($encrypted_attachment_id);
        $file = Attachment::find($id);



        $file->file_url = urldecode($file->file_url);

        $file_path = str_replace("http://team.webreinvent.com/", "", $file->file_url);


        $path = base_path()."/".$file_path;

        return response()->download($path);

    }

	//--------------------------------------------------------

	//--------------------------------------------------------

}
