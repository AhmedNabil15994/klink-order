<?php namespace App\Http\Middleware;

use App\Models\Rules;
use App\Models\User;
use Closure;

class RoutesGate {

    /*----------------------------------------------*/
    /*               Route Permissions              */
    /*----------------------------------------------*/

    public function handle($request, Closure $next) {

        $controllers = [

            /*----------------------------------------------*/
            /*               General Routes                 */
            /*----------------------------------------------*/
            'DomainAuthController@getlogin' => 'general',
            'DomainAuthController@postLogin' => 'general',
            'DomainAuthController@logout' => 'general',

        ];

        $route = \Route::getRoutes()->match($request);
        $route = $route->getActionName();
        $route = str_replace('\\','/',$route);
        $route = explode('/',$route);
        $currentController = end($route);

        $rules = isset($controllers[$currentController]) ? (array) $controllers[$currentController] : [];

        $availableRules = [
            'general',
            /*'list-users',
            'edit-user',
            'add-user',
            'delete-user',
            'list-groups',
            'edit-group',
            'add-group',
            'delete-group',*/
        ];
 
        if(count(array_intersect($availableRules, $rules)) > 0) {
            return $next($request);
        }

        $checkPermissions = User::userPermission($rules);

        if(!$checkPermissions) {
            return redirect('401');
        }

        return $next($request);
    }

}
