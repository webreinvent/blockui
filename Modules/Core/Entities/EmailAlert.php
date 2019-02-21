<?php
namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Emails\AdminWelcomeEmail;
use Modules\Core\Emails\TestEmail;

class EmailAlert extends Model
{
    //-------------------------------------------------
    protected $table = 'core_email_alerts';
    //-------------------------------------------------
    //-------------------------------------------------
    protected $dates = [
        'created_at', 'updated_at', 'sent_at', 'read_at'
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $fillable = [
        'type', 'label', 'core_user_id', 'from', 'to', 'subject',
        'message', 'meta', 'read_at', 'sent_at', 'status'
    ];
    //-------------------------------------------------
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
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
}
