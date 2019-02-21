<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;


class Review extends Model
{

	//-------------------------------------------------
	protected $table = 'core_reviews';
	//-------------------------------------------------
	protected $dates = [
		'created_at', 'updated_at', 'deleted_at'
	];
	//-------------------------------------------------
	protected $dateFormat = 'Y-m-d H:i:s';
	//-------------------------------------------------
	protected $fillable = [
        'rating_id', 'title', 'content', 'name', 'email', 'created_by', 'updated_by', 'deleted_by'
	];
	//-------------------------------------------------
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
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
