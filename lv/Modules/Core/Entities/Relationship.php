<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;


class Relationship extends Model
{

	//-------------------------------------------------
	protected $table = 'core_relationships';
	//-------------------------------------------------
	protected $dates = [
		'created_at', 'updated_at', 'deleted_at'
	];
	//-------------------------------------------------
	protected $dateFormat = 'Y-m-d H:i:s';
	//-------------------------------------------------
	protected $fillable = [
        'source_table_name', 'source_table_id', 'destination_table_name',
        'destination_table_id', 'category',
        'type', 'label', 'meta', 'created_by', 'updated_by', 'deleted_by',
	];
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
    public function rating() {
        return $this->belongsTo( 'Modules\Assignable\Entities\Technology',
                                 'as_technology_id', 'id'
        );
    }
	//-------------------------------------------------
	//-------------------------------------------------
}
