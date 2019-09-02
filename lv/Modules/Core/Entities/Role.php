<?php
namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Scope;
use Modules\Core\Entities\User;

class Role extends Model {
	use SoftDeletes;
	//-------------------------------------------------
	protected $table = 'core_roles';
	//-------------------------------------------------
	protected $dates = [
		'created_at',
		'updated_at',
		'deleted_at'
	];
	//-------------------------------------------------
	protected $dateFormat = 'Y-m-d H:i:s';
	//-------------------------------------------------
	protected $fillable = [
		'name',
		'slug',
		'details',
		'enable',
		'created_by',
		'updated_by',
		'deleted_by'
	];

	//-------------------------------------------------
	public function setNameAttribute( $value ) {
		$this->attributes['name'] = ucwords( $value );
	}
	//-------------------------------------------------
	public function setDetailsAttribute( $value ) {
		$this->attributes['details'] = ucfirst( $value );
	}
	//-------------------------------------------------

	//-------------------------------------------------
	public function scopeEnabled( $query ) {
		return $query->where( 'enable', 1 );
	}

	//-------------------------------------------------
	public function scopeDisabled( $query ) {
		return $query->where( 'enable', 0 );
	}

	//-------------------------------------------------
	public function scopeSlug( $query, $slug ) {
		return $query->where( 'slug', '=', $slug );
	}

	//-------------------------------------------------
	public function scopeCreatedBy( $query, $user_id ) {
		return $query->where( 'created_by', $user_id );
	}

	//-------------------------------------------------
	public function scopeUpdatedBy( $query, $user_id ) {
		return $query->where( 'updated_by', $user_id );
	}

	//-------------------------------------------------
	public function scopeDeletedBy( $query, $user_id ) {
		return $query->where( 'deleted_by', $user_id );
	}

	//-------------------------------------------------
	public function scopeCreatedBetween( $query, $from, $to ) {
		return $query->whereBetween( 'created_at', array( $from, $to ) );
	}

	//-------------------------------------------------
	public function scopeUpdatedBetween( $query, $from, $to ) {
		return $query->whereBetween( 'updated_at', array( $from, $to ) );
	}

	//-------------------------------------------------
	public function scopeDeletedBetween( $query, $from, $to ) {
		return $query->whereBetween( 'deleted_at', array( $from, $to ) );
	}

	//-------------------------------------------------
	public function createdBy() {
		return $this->belongsTo( 'Modules\Core\Entities\User',
			'created_by', 'id'
		);
	}

	//-------------------------------------------------
	public function updatedBy() {
		return $this->belongsTo( 'Modules\Core\Entities\User',
			'updated_by', 'id'
		);
	}

	//-------------------------------------------------
	public function deletedBy() {
		return $this->belongsTo( 'Modules\Core\Entities\User',
			'deleted_by', 'id'
		);
	}

	//-------------------------------------------------
	public function users() {
		return $this->belongsToMany( 'Modules\Core\Entities\User',
			'core_user_role', 'core_role_id', 'core_user_id'
		);
	}

	//-------------------------------------------------
	public function permissions() {
		return $this->belongsToMany( 'Modules\Core\Entities\Permission',
			'core_role_permission', 'core_role_id', 'core_permission_id'
		);
	}

	//-------------------------------------------------
	public function countTrashed() {
		return $this->onlyTrashed()->count();
	}

	//-------------------------------------------------
	//-------------------------------------------------
	//-------------------------------------------------
	//-------------------------------------------------
	//-------------------------------------------------
	//-------------------------------------------------
}
