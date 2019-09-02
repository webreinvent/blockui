<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;


class ChatArchive extends Model
{


    //-------------------------------------------------
    protected $table = 'chats';
    //-------------------------------------------------
    protected $dates = [
        'created_at', 'updated_at', 'read_at', 'archived_at'
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------

    protected $fillable = [
        'user_id', 'table_name', 'table_id', 'message', 'meta', 'read_at', 'archived_at'
    ];
    //-------------------------------------------------

    //-------------------------------------------------
    //-------------------------------------------------
    public function getMetaAttribute($value) {
        $json = json_decode($value);
        return $json;
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

    //-------------------------------------------------
}
