<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // create dashboard
        $year = $request->get('year', date('Y'));
        $year = $year > 1970 && $year < 9999 ? $year : 1970;


        $query =
            "SELECT
              d.id,  
              d.name,
              sum(if(p.oy = 1 and p.holat=1, soni, 0))  AS Jan_1,
              sum(if(p.oy = 1 and p.holat=0, soni, 0))  AS Jan_0,
              sum(if(p.oy = 2 and p.holat=1, soni, 0))  AS Feb_1,
              sum(if(p.oy = 2 and p.holat=0, soni, 0))  AS Feb_0,  
              sum(if(p.oy = 3 and p.holat=1, soni, 0))  AS March_1,
              sum(if(p.oy = 3 and p.holat=0, soni, 0))  AS March_0,  
              sum(if(p.oy = 4 and p.holat=1, soni, 0))  AS April_1,
              sum(if(p.oy = 4 and p.holat=0, soni, 0))  AS April_0,  
              sum(if(p.oy = 5 and p.holat=1, soni, 0))  AS May_1,
              sum(if(p.oy = 5 and p.holat=0, soni, 0))  AS May_0,   
              sum(if(p.oy = 6 and p.holat=1, soni, 0))  AS June_1,
              sum(if(p.oy = 6 and p.holat=0, soni, 0))  AS June_0,  
              sum(if(p.oy = 7 and p.holat=1, soni, 0))  AS July_1,
              sum(if(p.oy = 7 and p.holat=0, soni, 0))  AS July_0,  
              sum(if(p.oy = 8 and p.holat=1, soni, 0))  AS Aug_1,
              sum(if(p.oy = 8 and p.holat=0, soni, 0))  AS Aug_0,  
              sum(if(p.oy = 9 and p.holat=1, soni, 0))  AS Sep_1,
              sum(if(p.oy = 9 and p.holat=0, soni, 0))  AS Sep_0,  
              sum(if(p.oy = 10 and p.holat=1, soni, 0))  AS Oct_1,
              sum(if(p.oy = 10 and p.holat=0, soni, 0))  AS Oct_0,  
              sum(if(p.oy = 11 and p.holat=1, soni, 0))  AS Nov_1,
              sum(if(p.oy = 11 and p.holat=0, soni, 0))  AS Nov_0,
              sum(if(p.oy = 12 and p.holat=1, soni, 0))  AS Dec_1,
              sum(if(p.oy = 12 and p.holat=0, soni, 0))  AS Dec_0
            FROM (SELECT department_id, COUNT(id) as soni, MONTH(created_at) as oy, if(`status`=10,1,0) as holat  FROM `problems`
            WHERE year(created_at)=$year GROUP BY department_id, oy, holat) as p
            INNER JOIN departments d ON p.department_id=d.id
            GROUP BY d.id, d.name, p.department_id";

        $results = DB::select(DB::raw($query));

        $json_result = [];

        foreach ($results as $key => $value) {
            $a = [
                $value->Jan_1,
                $value->Feb_1,
                $value->March_1,
                $value->April_1,
                $value->May_1,
                $value->June_1,
                $value->July_1,
                $value->Aug_1,
                $value->Sep_1,
                $value->Oct_1,
                $value->Nov_1,
                $value->Dec_1,
            ];
            $b = [
                $value->Jan_0,
                $value->Feb_0,
                $value->March_0,
                $value->April_0,
                $value->May_0,
                $value->June_0,
                $value->July_0,
                $value->Aug_0,
                $value->Sep_0,
                $value->Oct_0,
                $value->Nov_0,
                $value->Dec_0,
            ];
            $json_result[] = [
                'nomi'=>$value->name,
                'sum1'=>array_sum($a),
                'sum2'=>array_sum($b)
            ];
        }

//        dd($json_result);
        $json_result = json_encode($json_result);

        return view('home', compact(
            'year', 'results','json_result'
        ));
    }
    public function home_m(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $year = $year > 1970 && $year < 9999 ? $year : 1970;
        $querym =
            "SELECT
              d.id,  
              d.name,
              sum(if(p.oy = 1 and p.holat=1, soni, 0))  AS Jan_1,
              sum(if(p.oy = 1 and p.holat=0, soni, 0))  AS Jan_0,
              sum(if(p.oy = 2 and p.holat=1, soni, 0))  AS Feb_1,
              sum(if(p.oy = 2 and p.holat=0, soni, 0))  AS Feb_0,  
              sum(if(p.oy = 3 and p.holat=1, soni, 0))  AS March_1,
              sum(if(p.oy = 3 and p.holat=0, soni, 0))  AS March_0,  
              sum(if(p.oy = 4 and p.holat=1, soni, 0))  AS April_1,
              sum(if(p.oy = 4 and p.holat=0, soni, 0))  AS April_0,  
              sum(if(p.oy = 5 and p.holat=1, soni, 0))  AS May_1,
              sum(if(p.oy = 5 and p.holat=0, soni, 0))  AS May_0,   
              sum(if(p.oy = 6 and p.holat=1, soni, 0))  AS June_1,
              sum(if(p.oy = 6 and p.holat=0, soni, 0))  AS June_0,  
              sum(if(p.oy = 7 and p.holat=1, soni, 0))  AS July_1,
              sum(if(p.oy = 7 and p.holat=0, soni, 0))  AS July_0,  
              sum(if(p.oy = 8 and p.holat=1, soni, 0))  AS Aug_1,
              sum(if(p.oy = 8 and p.holat=0, soni, 0))  AS Aug_0,  
              sum(if(p.oy = 9 and p.holat=1, soni, 0))  AS Sep_1,
              sum(if(p.oy = 9 and p.holat=0, soni, 0))  AS Sep_0,  
              sum(if(p.oy = 10 and p.holat=1, soni, 0))  AS Oct_1,
              sum(if(p.oy = 10 and p.holat=0, soni, 0))  AS Oct_0,  
              sum(if(p.oy = 11 and p.holat=1, soni, 0))  AS Nov_1,
              sum(if(p.oy = 11 and p.holat=0, soni, 0))  AS Nov_0,
              sum(if(p.oy = 12 and p.holat=1, soni, 0))  AS Dec_1,
              sum(if(p.oy = 12 and p.holat=0, soni, 0))  AS Dec_0
            FROM (SELECT vehicle_model_id, COUNT(id) as soni, MONTH(created_at) as oy, if(`status`=10,1,0) as holat  FROM `problems` WHERE year(created_at)=$year GROUP BY vehicle_model_id, oy, holat) as p
            INNER JOIN vehicle_models d ON p.vehicle_model_id=d.id
            GROUP BY d.id, d.name, p.vehicle_model_id";
        $resultsm = DB::select(DB::raw($querym));
        $json_resultm = [];
        foreach ($resultsm as $key => $value) {
            $a = [
                $value->Jan_1,
                $value->Feb_1,
                $value->March_1,
                $value->April_1,
                $value->May_1,
                $value->June_1,
                $value->July_1,
                $value->Aug_1,
                $value->Sep_1,
                $value->Oct_1,
                $value->Nov_1,
                $value->Dec_1,
            ];
            $b = [
                $value->Jan_0,
                $value->Feb_0,
                $value->March_0,
                $value->April_0,
                $value->May_0,
                $value->June_0,
                $value->July_0,
                $value->Aug_0,
                $value->Sep_0,
                $value->Oct_0,
                $value->Nov_0,
                $value->Dec_0,
            ];
            $json_resultm[] = [
                'nomi'=>$value->name,
                'sum1'=>array_sum($a),
                'sum2'=>array_sum($b)
            ];
        }
        $json_resultm = json_encode($json_resultm);
        return view('home_m', compact(
            'year', 'resultsm','json_resultm'
        ));
    }
    public function overall(Request $request)
    {
        // create dashboard
        $year = $request->get('year', date('Y'));
        $year = $year > 1970 && $year < 9999 ? $year : 1970;

        $telegram = "
            select MONTH(t.created_at) oylar, count(t.id) muammo_soni, count(if(status = 0, t.id, null)) as holat
            from problems t     
            where problem_type_id = 2
            and year(created_at)=$year
            group by oylar
        ";
        $telegram = DB::select($telegram);

        $tus = "
        SELECT count(id) as usoni, count(if(status = 0, id, null)) as ochiq FROM `problems` 
        WHERE problem_type_id = 2
        and year(created_at)=$year
        ";
        $tus = DB::select($tus);

        $allproblem = "
            select MONTH(t.created_at) oylar, count(t.id) muammo_soni, count(if(status = 0, t.id, null)) as holat
            from problems t     
            where year(created_at)=$year
            group by oylar
        ";
        $allproblem = DB::select($allproblem);

        $sumproblem =  "
        SELECT count(id) as usoni, count(if(status = 0, id, null)) as ochiq FROM `problems` 
        WHERE year(created_at)=$year
        ";

        $sumproblem = DB::select($sumproblem);

        $telegram = json_encode($telegram);
        $tus = json_encode($tus);

        $allproblem = json_encode($allproblem);
        $sumproblem = json_encode($sumproblem);

        return view('overall', compact(
            'year', 'telegram','tus','allproblem','sumproblem'
        ));

    }


    public function showChangePasswordForm()
    {
        return view('auth.passwords.changepassword');
    }

    public function changePassword(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", trans('app.messages.password.check'));
        }
        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with("error", trans('app.messages.password.sameWithCurrent'));
        }
        $this->validate($request, [
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect()->back()->with("success", trans('app.messages.password.changed'));
    }

    public function postEdit(Request $request)
    {
        $app_id = $request->get('app_id');
        $comment = $request->get('comment');

        \DB::table('problem_actions')->where('id', $app_id)->update(['content' => $comment]);

        return redirect()->back();
    }

}
