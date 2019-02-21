<?php
namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model {
	use SoftDeletes;
	//-------------------------------------------------
	protected $table = 'core_permissions';
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
		'prefix',
		'created_by',
		'updated_by',
		'deleted_by'
	];

	//-------------------------------------------------
	public function setNameAttribute( $value ) {
		$this->attributes['name'] = ucwords( str_replace( "-", " ", $value ) );
	}

	//-------------------------------------------------
	public function setSlugAttribute( $value ) {
		$this->attributes['slug'] = str_slug( $value );
	}

	//-------------------------------------------------
	public function setPrefixAttribute( $value ) {
		$this->attributes['prefix'] = strtolower( $value );
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
	public function roles() {
		return $this->belongsToMany( 'Modules\Core\Entities\Role',
			'core_role_permission', 'core_permission_id', 'core_role_id'
		);
	}

	//-------------------------------------------------
	public static function syncWithAdmin() {
		try {
			//get all the permissions
			$permissions = Permission::pluck( 'id' )->toArray();
			//sync with admins
			$role = Role::slug( 'admin' )->first();
			$role->permissions()->sync( $permissions );
			$response['status'] = 'success';
		} catch ( Exception $e ) {
			$response['status']   = 'failed';
			$response['errors'][] = $e->getMessage();
		}

		return $response;
	}
	//-------------------------------------------------
	//-------------------------------------------------
	//-------------------------------------------------
}
