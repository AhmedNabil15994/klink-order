<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
	public $timestamps = false;
	protected $table = 'user_profiles';
	
	public function User(){
		return $this->belongsTo('App\Models\User','user_id','id');
	}

	public function Numbers(){
		return $this->belongsTo('App\Models\Number','number_id','id');
	}

	public function Address(){
		return $this->belongsTo('App\Models\Address','address_id','id');
	}

	public function Group(){
		return $this->belongsTo('App\Models\Group','group_id','id');
	}

	public function name(){
		return $this->first_name .' '.$this->last_name;
	}

}