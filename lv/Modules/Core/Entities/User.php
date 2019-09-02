<?php
namespace Modules\Core\Entities;


use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Password;
use ResetsPasswords;


use Modules\Core\Entities\Premission;
use Modules\Core\Events\UserLoggedIn;
use Modules\Core\Notifications\NotifyAdmin;
use Notification;

class User extends Authenticatable
{
    use Notifiable;

    use SoftDeletes;
    //-------------------------------------------------
    protected $table = 'core_users';
    //-------------------------------------------------
    protected $dates = [
        'birth_date',
        'activated_at',
        'last_login',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'mobile',
        'country_calling_code',
        'gender',
        'birth_date',
        'enable',
        'activation_code',
        'activated_at',
        'last_login',
        'last_login_ip',
        'api_token',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
    //-------------------------------------------------
    protected $hidden = [
        'password',
        'remember_token',
    ];

    //-------------------------------------------------

    //-------------------------------------------------
    protected $appends  = [
        'thumbnail',
    ];

    //-------------------------------------------------
    public function getThumbnailAttribute() {


        $rules = array(
            'email' => 'required|email',
        );

        $validator = \Validator::make( ['email' => $this->email], $rules);
        if ( $validator->fails() ) {
            return null;
        }

        $grav_url = User::avatarByEmail($this->email);
        //$grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $this->email ) ) )."&s=30&&d=monsterid";

        return $grav_url;
    }
    //-------------------------------------------------
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }

    //-------------------------------------------------
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    //-------------------------------------------------
    public function setMobileAttribute($value)
    {
        $value = trim(str_replace("-", "", $value));

        if ( empty($value) )
        { // will check for empty string
            $value = NULL;
        }

        $this->attributes['mobile'] = $value;
    }

    //-------------------------------------------------
    public function scopeEnabled($query)
    {
        return $query->where('enable', 1);
    }

    //-------------------------------------------------
    public function scopeDisabled($query)
    {
        return $query->where('enable', 0);
    }

    //-------------------------------------------------
    public function scopeUsername($query, $username)
    {
        return $query->where('username', $username);
    }

    //-------------------------------------------------
    public function scopeEmail($query, $email)
    {
        return $query->where('email', $email);
    }

    //-------------------------------------------------
    public function scopeMobile($query, $mobile)
    {
        return $query->where('mobile', $mobile);
    }

    //-------------------------------------------------
    public function scopeActivatedBetween($query, $from, $to)
    {
        return $query->whereBetween('activated_at', array($from, $to));
    }

    //-------------------------------------------------
    public function scopeCreatedBy($query, $user_id)
    {
        return $query->where('created_by', $user_id);
    }

    //-------------------------------------------------
    public function scopeUpdatedBy($query, $user_id)
    {
        return $query->where('updated_by', $user_id);
    }

    //-------------------------------------------------
    public function scopeDeletedBy($query, $user_id)
    {
        return $query->where('deleted_by', $user_id);
    }

    //-------------------------------------------------
    public function scopeCreatedBetween($query, $from, $to)
    {
        return $query->whereBetween('created_at', array($from, $to));
    }

    //-------------------------------------------------
    public function scopeUpdatedBetween($query, $from, $to)
    {
        return $query->whereBetween('updated_at', array($from, $to));
    }

    //-------------------------------------------------
    public function scopeDeletedBetween($query, $from, $to)
    {
        return $query->whereBetween('deleted_at', array($from, $to));
    }

    //-------------------------------------------------
    public function scopeActivated($query)
    {
        return $query->whereNotNull('activated_at');
    }

    //-------------------------------------------------
    public function scopeNotActivated($query)
    {
        return $query->whereNull('activated_at');
    }

    //-------------------------------------------------
    public function scopeLoggedInBetween($query, $from, $to)
    {
        return $query->whereBetween('last_login', array($from, $to));
    }

    //-------------------------------------------------
    public function scopeNeverLoggedIn($query)
    {
        return $query->whereNull('last_login');
    }

    //-------------------------------------------------
    public function scopeDoesNotHaveRole($query, $role_id)
    {
        return $query->whereDoesntHave('roles', function ($r) use ($role_id)
        {
            $r->where('core_role_id', $role_id);
        });
    }
    //-------------------------------------------------
    public function createdBy()
    {
        return $this->belongsTo('Modules\Core\Entities\User',
                                'created_by', 'id'
        );
    }

    //-------------------------------------------------
    public function updatedBy()
    {
        return $this->belongsTo('Modules\Core\Entities\User',
                                'updated_by', 'id'
        );
    }

    //-------------------------------------------------
    public function deletedBy()
    {
        return $this->belongsTo('Modules\Core\Entities\User',
                                'deleted_by', 'id'
        );
    }

    //-------------------------------------------------
    public static function findByUsername($username, $columns = array('*'))
    {
        if ( ! is_null($user = static::whereUsername($username)->first($columns))) {
            return $user;
        } else
        {
            return false;
        }

    }
    //-------------------------------------------------
    public static function findByEmail($email, $columns = array('*'))
    {
        if ( ! is_null($user = static::whereEmail($email)->first($columns))) {
            return $user;
        }else
        {
            return false;
        }
    }
    //-------------------------------------------------
    public static function findByMobile($mobile, $columns = array('*'))
    {
        if ( ! is_null($user = static::whereMobile($mobile)->first($columns))) {
            return $user;
        }else
        {
            return false;
        }
    }



    //-------------------------------------------------
    public function roles()
    {
        return $this->belongsToMany('Modules\Core\Entities\Role',
                                    'core_user_role', 'core_user_id', 'core_role_id'
        );
    }

    //-------------------------------------------------
    public function countAdmins()
    {
        $count = User::whereHas('roles', function ($query) {
            $query->slug('admin');
        })->count();
        return $count;
    }

    //-------------------------------------------------
    public function listByRole($role_slug)
    {
        $this->role_slug = $role_slug;
        $list = User::whereHas('roles', function ($query) {
            $query->slug($this->role_slug);
        })->where('enable', 1)->get();
        return $list;
    }

    //-------------------------------------------------
    public static function getByRoles($array_role_slugs)
    {

        $list = User::whereHas('roles', function ($query) use ($array_role_slugs)
        {
            if(count($array_role_slugs))
            {
                $i = 0;
                foreach ($array_role_slugs as $slug)
                {
                    if($i == 0)
                    {
                        $query->where('slug', $slug);
                    } else
                    {
                        $query->orWhere('slug', $slug);
                    }
                    $i++;
                }
            }

        })->with(['roles'])->where('enable', 1)->get();

        return $list;
    }
    //-------------------------------------------------
    public static function getByRolesOnlyIds($array_role_slugs)
    {
        $list = User::getByRoles($array_role_slugs)->pluck('id')->toArray();
        return $list;
    }
    //-------------------------------------------------
    public static function getByRolesOnlyEmails($array_role_slugs)
    {
        $list = User::getByRoles($array_role_slugs)->pluck('email')->toArray();
        return $list;
    }
    //-------------------------------------------------
    public function permissions()
    {
        $roles = $this->roles()->get();
        $permissions_list = array();
        foreach ($roles as $role) {
            $permissions = $role->permissions()->get();
            foreach ($permissions as $permission) {
                $permissions_list[$permission->id] = $permission->toArray();
            }
        }
        return $permissions_list;
    }

    //-------------------------------------------------
    public function getByEmail($email)
    {
        try {
            $user = User::where('email', $email)->firstOrFail();
            $response['status'] = 'success';
            $response['data'] = $user;
            return $response;
        } catch (\Exception $e) {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
            return $response;
        }
    }

    //-------------------------------------------------
    public function getByMobile($mobile)
    {
        try {
            $user = User::where('mobile', $mobile)->firstOrFail();
            $response['status'] = 'success';
            $response['data'] = $user;
            return $response;
        } catch (\Exception $e) {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
            return $response;
        }
    }

    //-------------------------------------------------
    public function getByUsername($username)
    {
        try {
            $user = User::where('username', $username)->firstOrFail();
            $response['status'] = 'success';
            $response['data'] = $user;
            return $response;
        } catch (\Exception $e) {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
            return $response;
        }
    }

    //-------------------------------------------------
    public static function rulesAdminCreate()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:core_users|max:255',
            'mobile' => 'required|unique:core_users|max:10',
            'username' => 'unique:core_users|max:20',
            'password' => 'required|max:255',
        ];
        return $rules;
    }



    //-------------------------------------------------
    public function scopeListByPermission($query, $permission_slug)
    {
        return $query->whereHas('roles', function ($q) use ($permission_slug)
        {
            $q->whereHas('permissions', function ($p) use ($permission_slug) {
                $p->where('slug', $permission_slug);
            })->orWhere('slug', 'admin');
        });
    }

    //-------------------------------------------------
    public static function login($request)
    {

        //check if already logged in
        if (Auth::check())
        {
            Auth::logout();
        }

        $rules = array(
            'email' => 'required',
        );
        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            $errors = $validator->errors();
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }


        $inputs = $request->all();
        $inputs['email'] = trim($inputs['email']);

        $rules = array(
            'email' => 'required|email',
            'password' => 'required',
        );
        $validator = \Validator::make($inputs, $rules);

        if ($validator->fails())
        {
            $errors = $validator->errors();
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }

        $remember = false;
        if ($request->has("remember") || $request->get("remember") == "on") {
            $remember = true;
        }


        if (Auth::attempt(['email' => $inputs['email'],
                            'password' => trim($request->get('password'))
                          ], $remember))
        {
            $user = Auth::user();

            //check user is active
            if($user->enable == 0)
            {
                $response['status'] = 'failed';
                $response['errors'][] = getConstant('account.disabled');
                return $response;
            }

            $user->last_login = \Carbon::now();
            $user->save();

            //fire the event
            event(new UserLoggedIn(Auth::user()));
            $response['status'] = 'success';
            $response['data'] = Auth::user();
            $redirect = $request->input('redirect_url', \URL::route('core.backend.dashboard'));
            $response['redirect_url'] = $redirect;


        } else {
            $response['status'] = 'failed';
            $response['errors'][] = getConstant('credentials.invalid');

        }

        return $response;
    }
    //-------------------------------------------------
    public static function resetPasswordEmail($request)
    {

        $inputs = $request->all();


        $rules = array(
            'email' => 'required'
        );
        $validator = \Validator::make($inputs, $rules);

        if ($validator->fails())
        {
            $errors = $validator->errors();
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }

        $inputs['email'] = trim($inputs['email']);

        $rules = array(
            'email' => 'required|email'
        );
        $validator = \Validator::make($inputs, $rules);

        if ($validator->fails())
        {
            $errors = $validator->errors();
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }

        $response = Password::sendResetLink(array('email'=>$inputs['email']), function (Message $message) {
            $message->subject('Reset your password');
        });



        switch ($response) {
            case Password::RESET_LINK_SENT:
                $result['status'] = 'success';
                break;

            case Password::INVALID_USER:

                $result['status'] = 'failed';
                $result['errors'][]= 'Invalid User';
                break;
        }

        return $result;

    }
    //-------------------------------------------------
    public function hasRole($role_slug)
    {
        foreach ($this->roles()->get() as $role) {
            if ($role->slug == $role_slug)
            {
                return true;
            }
        }
        return false;
    }

    //-------------------------------------------------

    //-------------------------------------------------
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    //-------------------------------------------------
    public function hasPermission($prefix, $permission_slug)
    {
        $permission_slug = str_slug($permission_slug);

        //check if permission exist or not
        $permission = Permission::where('slug', $permission_slug)
            ->where('prefix', $prefix)
            ->first();
        if (!$permission)
        {
            //if only slug exist then delete the current permission record and create new
            Permission::where('slug', $permission_slug)->forceDelete();

            $permission = new Permission();
            $permission->slug = $permission_slug;
            $permission->name = $permission_slug;
            $permission->prefix = $prefix;
            $permission->enable = 1;
            $permission->save();
            Permission::syncWithAdmin();
        }
        if ($this->isAdmin()) {
            return true;
        }
        if ($permission->enable == 0) {
            return false;
        }
        foreach ($this->permissions() as $permission) {
            if ($permission['slug'] == $permission_slug
                && $permission['prefix'] == $prefix
                && $permission['enable'] = 1
            ) {
                return true;
            }
        }
        return false;
    }

    //-------------------------------------------------
    public static function avatarByEmail($email)
    {
        try {
            $image = \Gravatar::fallback(assetsCoreMmenu() . "/images/user.png")->get($email);
            /*$file_headers = @get_headers($image);
            if (!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
                $image = asset("assets/core/images/user.png");
            }*/
        } catch (Exception $e) {
            $image = asset("assets/core/images/user.png");
        }
        return $image;
    }
    //-------------------------------------------------
    public static function avatar($id)
    {
        $user = User::find($id);
        $image = User::avatarByEmail($user->email);
        return $image;
    }

    //-------------------------------------------------
    public static function notifyAdmins($subject, $message)
    {
        $users = new User();
        $admins = $users->listByRole('admin');

        $notification = new \stdClass();
        $notification->subject = $subject;
        $notification->message = $message;

        Notification::send($admins, new NotifyAdmin($notification));
    }
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
    public function activities()
    {
        return Activity::where('table_name', 'core_users')->where('table_id', $this->id);
    }
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
}
