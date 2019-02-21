<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;


class Reaction extends Model
{


	//-------------------------------------------------
	protected $table = 'core_discussion_reactions';
	//-------------------------------------------------
	protected $dates = [
		'created_at', 'updated_at'
	];
	//-------------------------------------------------
	protected $dateFormat = 'Y-m-d H:i:s';
	//-------------------------------------------------

	protected $fillable = [
		'discussion_id', 'emoji', 'text', 'table_name', 'table_id', 'meta', 'created_by'
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
    public function scopeCreatedBy( $query, $user_id ) {
        return $query->where( 'created_by', $user_id );
    }

	//-------------------------------------------------
	//-------------------------------------------------
	//-------------------------------------------------
}
