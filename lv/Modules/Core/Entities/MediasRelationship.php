<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;


class MediasRelationship extends Model
{


	//-------------------------------------------------
	protected $table = 'core_medias_relationship';
	//-------------------------------------------------
	protected $dates = [
		'created_at', 'updated_at',
	];
	//-------------------------------------------------
	protected $dateFormat = 'Y-m-d H:i:s';
	//-------------------------------------------------

	protected $fillable = [
		'id', 'core_media_id', 'category', 'type', 'table_name', 'table_id',
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
    public function media() {
        return $this->belongsTo( 'Modules\Core\Entities\Media',
                                 'core_media_id', 'id'
        );
    }
	//-------------------------------------------------
	//-------------------------------------------------
	//-------------------------------------------------
	//-------------------------------------------------
}
