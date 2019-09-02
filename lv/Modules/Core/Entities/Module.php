<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
	//-------------------------------------------------
	protected $table = 'core_modules';
	//-------------------------------------------------
	protected $dates = [
		'created_at', 'updated_at', 'deleted_at'
	];
	//-------------------------------------------------
	protected $dateFormat = 'Y-m-d H:i:s';
	//-------------------------------------------------
	protected $fillable = [
		'name', 'slug', 'details',
		'meta', 'version_major', 'version_minor', 'version_revision', 'version_build',
	];
	//-------------------------------------------------
	//-------------------------------------------------
	public function scopeEnabled($query)
	{
		return $query->where('enable', 1);
	}

	//-------------------------------------------------
	public function scopeDisabled($query)
	{
		return $query->where('enable', 0);
	}
	//-------------------------------------------------
	public function scopeNames($query)
	{
		return $query->pluck('name');
	}
	//-------------------------------------------------
	public function scopeSlugs($query)
	{
		return $query->pluck('slug');
	}
	//-------------------------------------------------
	//-------------------------------------------------
	//-------------------------------------------------
}
