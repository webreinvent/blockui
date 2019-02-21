<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;


class Attachment extends Model
{


	//-------------------------------------------------
	protected $table = 'core_attachments';
	//-------------------------------------------------
	protected $dates = [
		'created_at', 'updated_at', 'deleted_at'
	];
	//-------------------------------------------------
	protected $dateFormat = 'Y-m-d H:i:s';
	//-------------------------------------------------

	protected $fillable = [
		'file_name', 'file_url', 'type', 'table_name', 'table_id', 'meta', 'created_by', 'updated_by', 'deleted_by'
	];
	//-------------------------------------------------
    protected $appends  = [
        'encrypted_id', 'download_url'
    ];
	//-------------------------------------------------
    public function getEncryptedIdAttribute() {

        $encrypted_id = \Crypt::encrypt($this->id);

        return $encrypted_id;
    }
	//-------------------------------------------------
    public function getDownloadUrlAttribute() {

        $encrypted_id = \Crypt::encrypt($this->id);

        $url = \URL::route("core.download.file", [$encrypted_id]);

        return $url;
    }
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
	//-------------------------------------------------
	//-------------------------------------------------
}
