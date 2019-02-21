<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{

    use SoftDeletes;

	//-------------------------------------------------
	protected $table = 'core_comments';
	//-------------------------------------------------
	protected $dates = [
		'created_at', 'updated_at', 'deleted_at', 'sent_at'
	];
	//-------------------------------------------------
	protected $dateFormat = 'Y-m-d H:i:s';
	//-------------------------------------------------

	protected $fillable = [
		'parent_comment_id', 'subject', 'content', 'type', 'table_name', 'table_id', 'meta',
        'sent_at', 'created_by', 'updated_by', 'deleted_by'
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
	public function scopeDeletedBetween($query, $from, $to)
	{
		return $query->whereBetween('deleted_at', array($from, $to));
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
    //-------------------------------------------------
    public function createdBy()
    {
        return $this->belongsTo('Modules\Core\Entities\User',
                                'created_by', 'id'
        );
    }

    //-------------------------------------------------
    public function updatedBy()
    {
        return $this->belongsTo('Modules\Core\Entities\User',
                                'updated_by', 'id'
        );
    }

    //-------------------------------------------------
    public function deletedBy()
    {
        return $this->belongsTo('Modules\Core\Entities\User',
                                'deleted_by', 'id'
        );
    }
	//-------------------------------------------------
    public function users() {
        return $this->belongsToMany('Modules\Core\Entities\User',
                                    'core_comment_users', 'core_comment_id', 'core_user_id'
        );
    }
	//-------------------------------------------------
    public function attachments()
    {
        return $this->hasMany( 'Modules\Core\Entities\Attachment',
                               'table_id', 'id'
        )->where('table_name', 'core_comments');
    }
	//-------------------------------------------------
    public function reactions()
    {
        return $this->hasMany( 'Modules\Core\Entities\Reaction',
                               'table_id', 'id'
        )->where('table_name', 'core_comments');
    }
	//-------------------------------------------------
    public static function getCounter($table_name, $table_id)
    {
        $last = Comment::where('table_name', $table_name)
            ->where('table_id', $table_id)
            ->withTrashed()
            ->max('counter');

        if(!$last)
        {
            return 1;
        }

        $counter = $last+1;

        return $counter;
    }
	//-------------------------------------------------
	//-------------------------------------------------
	//-------------------------------------------------
}
