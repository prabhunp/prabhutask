<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDetails extends Model {
	use SoftDeletes;

	public $table = "users_details";

    protected $primaryKey = 'id';

	public $fillable = ['first_name','last_name','birthday','height','weight','profile_image','country','team_name','position','college','member','debut'];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    public static function userCreate(array $attributes = []) {
        $user =	parent::create($attributes);		
        return $user;
    }
    
}
