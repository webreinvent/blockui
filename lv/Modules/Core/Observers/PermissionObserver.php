<?php

namespace Modules\Core\Observers;

use Modules\Core\Entities\Permission;

class PermissionObserver
{
	//-----------------------------------------------------------
	protected $user_id;
	//-----------------------------------------------------------
	public function __construct($user_id = NULL){

		if($user_id == NULL)
		{
			if(\Auth::check())
			{
				$this->user_id = \Auth::user()->id;
			}
		} else
		{
			$this->user_id = $user_id;
		}


	}
	//-----------------------------------------------------------

	public function creating($model)
	{
		if(!isset($model->created_by) )
		{
			$model->created_by = $this->user_id;
		}

		if(!isset($model->slug) )
		{
			$model->slug = str_slug($model);
		}
		return $model;
	}
	//-----------------------------------------------------------
	public function created($model)
	{
		//
	}

	//-----------------------------------------------------------
	public function saving($model)
	{
		if(!isset($model->created_by) )
		{
			$model->created_by = $this->user_id;
		}

		if(!isset($model->slug) )
		{
			$model->slug = str_slug($model->name);
		}
		return $model;
	}


	//-----------------------------------------------------------
	public function saved($model)
	{
		//
	}
	//-----------------------------------------------------------
	public function updating($model)
	{
		if(!isset($model->updated_by) )
		{
			$model->updated_by = $this->user_id;
		}

		return $model;
	}
	//-----------------------------------------------------------
	public function updated($model)
	{

	}
	//-----------------------------------------------------------
	public function deleting($model)
	{
		//
		if(!isset($model->deleted_by) )
		{
			$model->deleted_by = $this->user_id;
		}
	}
	//-----------------------------------------------------------
	public function deleted($model)
	{
	}
	//-----------------------------------------------------------
	public function restoring($model)
	{
		//
		if(!isset($model->deleted_by) )
		{
			$model->deleted_by = NULL;
		}

	}
	//-----------------------------------------------------------
	public function restored($model)
	{
		if(!isset($model->deleted_by) )
		{
			$model->deleted_by = NULL;
		}

	}
	//-----------------------------------------------------------
	//-----------------------------------------------------------
	//-----------------------------------------------------------
}
