<?php
namespace Modules\Core\Entities;


use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Password;



use App\Premission;
use Notification;

class UserTemporary extends Authenticatable
{
    use Notifiable;

    //-------------------------------------------------
    protected $table = 'core_users_temporary';
    //-------------------------------------------------
    protected $dates = [
        'email_sent_at',
        'created_at',
        'updated_at',

    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $fillable = [
        'name',
        'email',
        'country_calling_code',
        'mobile',
        'password',
        'activation_code',
        'email_sent_at',
        'resend_attempts',
        'activation_attempts',
    ];
    //-------------------------------------------------

    //-------------------------------------------------
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
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
}
