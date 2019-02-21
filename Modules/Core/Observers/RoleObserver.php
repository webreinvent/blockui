<?php
namespace Modules\Core\Observers;

use Modules\Core\Entities\Role;

class RoleObserver {
	//-----------------------------------------------------------
	protected $user_id;

	//-----------------------------------------------------------
	public function __construct( $user_id = null ) {
		if ( $user_id == null ) {
			if ( \Auth::check() ) {
				$this->user_id = \Auth::user()->id;
			}
		} else {
			$this->user_id = $user_id;
		}
	}

	//-----------------------------------------------------------
	public function creating( $model ) {
		if ( ! isset( $model->created_by ) ) {
			$model->created_by = $this->user_id;
		}
		if ( ! isset( $model->slug ) ) {
			$model->slug = str_slug( $model );
		}

		return $model;
	}

	//-----------------------------------------------------------
	public function created( $model ) {
		//
	}

	//-----------------------------------------------------------
	public function saving( $model ) {
		if ( ! isset( $model->created_by ) ) {
			$model->created_by = $this->user_id;
		}
		if ( ! isset( $model->slug ) ) {
			$model->slug = str_slug( $model->name );
		}

		return $model;
	}

	//-----------------------------------------------------------
	public function saved( $model ) {
		//
	}

	//-----------------------------------------------------------
	public function updating( $model ) {
		$model->updated_by = $this->user_id;

		return $model;
	}

	//-----------------------------------------------------------
	public function updated( $model ) {

	}

	//-----------------------------------------------------------
	public function deleting( $model ) {
		$model->deleted_by = $this->user_id;
		$model->enable     = 0;
		$model->save();

		return $model;
	}

	//-----------------------------------------------------------
	public function deleted( $model ) {
	}

	//-----------------------------------------------------------
	public function restoring( $model ) {
	}

	//-----------------------------------------------------------
	public function restored( $model ) {
		$model->deleted_by = null;
		$model->save();

		return $model;
	}
	//-----------------------------------------------------------
	//-----------------------------------------------------------
	//-----------------------------------------------------------
}
