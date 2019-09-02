<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;


class SlugLog extends Model
{

	//-------------------------------------------------
	protected $table = 'core_slug_logs';
	//-------------------------------------------------
	protected $dates = [
		'created_at', 'updated_at', 'deleted_at'
	];
	//-------------------------------------------------
	protected $dateFormat = 'Y-m-d H:i:s';
	//-------------------------------------------------
	protected $fillable = [
        'table_name', 'table_id', 'table_id', 'created_by', 'updated_by', 'deleted_by'
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
    public function scopeCreatedBy( $query, $user_id ) {
        return $query->where( 'created_by', $user_id );
    }

	//-------------------------------------------------
	//-------------------------------------------------
	//-------------------------------------------------
}
