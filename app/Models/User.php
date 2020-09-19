<?php 

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use ResetPasswordNotification;

class User extends Authenticatable
{	
    use Notifiable;
    use \TraitsFunc;

	public $timestamps = false;
	protected $table = 'users';
	
	protected $hidden = [
        'password', 'remember_token',
    ];
	
	function Profile(){
        return $this->hasOne('App\Models\Profile', 'user_id');
    }

    // Users Permissions
    static function checkUserPermissions($userObj) {

        $groupObj = $userObj->Profile->Group;
        $groupPermissions = $groupObj != null ? $groupObj->permissions : null;


        $permissions = (array) $groupPermissions;
        return $permissions;
    }

    static function userPermission(array $rule){
        if(IS_ADMIN == false) {
            return count(array_intersect($rule, PERMISSIONS)) > 0 ? true : false;
        }

        return true;
    }

}
