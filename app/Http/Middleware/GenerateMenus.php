<?php

namespace App\Http\Middleware;

use Closure;
use Menu;
use Illuminate\Contracts\Auth\Guard;

class GenerateMenus
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $this->auth->user();
        Menu::make('MainMenu', function ($menu) use($user){
            if(!$this->auth->guest()) {
                $menu->add(trans('app.menu.problems'), 'problems');
                $menu->add(trans('app.menu.report'))->nickname('Report');
                $menu->item('Report')->add(trans('app.menu.suppliers'), 'group_problem/all');
//                $menu->item('Report')->add(trans('app.menu.suppliers'), 'group_problem');
                if($user->hasRole('admin')){
                    $menu->add(trans('app.menu.administration'))->nickname('administration');
		            $menu->item('administration')->add(trans('app.menu.suppliers'), 'departments');
                    $menu->item('administration')->add(trans('app.menu.dealers'), 'dealers');
                    
                    $menu->item('administration')->add(trans('app.menu.stages'), 'stages');
                    $menu->item('administration')->add(trans('app.menu.stageGroups'), 'stage-groups');
                    $menu->item('administration')->add(trans('app.menu.problemTypes'), 'problem-types');
                    $menu->item('administration')->add(trans('app.menu.models'), 'vehicle-models');
                    $menu->item('administration')->add(trans('app.menu.users'), 'users');
                    $menu->item('administration')->add(trans('app.menu.email-list'), 'email-list');

                    $menu->add(trans('app.menu.check_sheet'))->nickname('Check Sheet');
                    $menu->item('Check Sheet')->add(trans('app.menu.level1'), 'level1');
                    $menu->item('Check Sheet')->add(trans('app.menu.level2'), 'level2');
                    $menu->item('Check Sheet')->add(trans('app.menu.fault_type'), 'fault_type');

                }

            }
        });

        return $next($request);
    }
}
