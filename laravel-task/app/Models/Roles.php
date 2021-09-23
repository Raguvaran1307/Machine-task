<?php
namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'guard_name',
        'name',
    ];
	
    // ELOQUENT ORM RELATIONSHIPS FUNCTIONS
    public function roles()
    {
    	return $this->belongsTo('App\Models\User','roles','id');
    }
}