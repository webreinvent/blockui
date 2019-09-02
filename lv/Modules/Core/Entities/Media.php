<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;


class Media extends Model
{

	//-------------------------------------------------
	protected $table = 'core_medias';
	//-------------------------------------------------
	protected $dates = [
		'created_at', 'updated_at', 'deleted_at'
	];
	//-------------------------------------------------
	protected $dateFormat = 'Y-m-d H:i:s';
	//-------------------------------------------------

	protected $fillable = [
		'id', 'name', 'url', 'ext', 'category', 'table_name', 'table_id',
	];
	//-------------------------------------------------

	//-------------------------------------------------
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
	public function scopeDeletedBetween($query, $from, $to)
	{
		return $query->whereBetween('deleted_at', array($from, $to));
	}
	//-------------------------------------------------
    public function relationships() {
        return $this->hasMany('Modules\Core\Entities\MediasRelationship',
                                    'core_media_id', 'id'
        );
    }
	//-------------------------------------------------
	//-------------------------------------------------
	//-------------------------------------------------
	//-------------------------------------------------
}
