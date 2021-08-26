<?php

namespace App\Http\Controllers;

use App\Email_list;
use App\For_detail;
use App\Level_second;
use App\Problem;
use App\ProblemActions;
use App\ProblemType;
use App\Stage;
use App\StageGroup;
use App\Department;
use App\Region;
use App\User;
use App\VehicleModel;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ProblemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
        $user = Auth::user();
//        $me = Auth::user()->id;
        $ac = User::with('departments')->where('id',$user->id)->first();
//        dd($ac->departments[0]->name); die();
        $shart = false;
        if (isset($ac->departments[0]->name)):
        $shart = ($ac->departments[0]->name == 'A/C') ? true : false;
        endif;


        $data = $request->all();

        $filter = StageGroup::with('stages')->get();
        $query = Problem::query();
        $query->with(['stage', 'region','department', 'problemType'])->orderBy('created_at','DESC');
        // by filters
        if ($request->has('id')) {
            $query->where('id', '=', $request->id);
        }
        if($request->has('vin')){
            $query->where('vin', 'like', '%'.$request->get('vin').'%');
        }
        if($request->has('description')){
            $query->where('description', 'like', '%'.$request->get('description').'%');
        }
        if($request->has('created_at')){
            $query->where('created_at', 'like', '%'.$request->get('created_at').'%');
        }
        if ($request->has('current_stage_id')) {
            $query->where('current_stage_id', '=', $request->current_stage_id);
        }
        if ($request->has('vehicle_model_id')) {
            $query->where('vehicle_model_id', '=', $request->vehicle_model_id);
        }

        if ($request->has('dealer_id')) {
            $query->where('dealer_id', '=', $request->dealer_id);
        }

        if ($request->has('fault_type_id')) {
            $query->where('fault_type_id', '=', $request->fault_type_id);
        }
        if ($request->has('level_second_id')) {
            $query->where('level_second_id', '=', $request->level_second_id);
        }
        if ($request->has('region_id')) {
            $query->where('region_id', '=', $request->region_id);
        }

        if($request->has('part_type')){
            $query->where('part_type', 'like', '%'.$request->get('part_type').'%');
        }
        if($request->has('part_number')){
            $query->where('part_number', 'like', '%'.$request->get('part_number').'%');
        }

        if ($request->has('department_id')) {
            $query->where('department_id', '=', $request->department_id);
        }
        if ($request->has('problem_type_id')) {
            $query->where('problem_type_id', '=', $request->problem_type_id);
        }
        if ($request->has('status')) {
            $query->where('status', '=', $request->status);
        }
        if ($request->has('month')) {
            $query->whereRaw('month(problems.created_at)=' . $request->get('month'));
        }
        if ($request->has('year')) {
            $query->whereRaw('year(problems.created_at)=' . $request->get('year'));
        }
        // by roles
        if ($user->hasRole('department')) {
            $query->where('department_id', '=', $user->departments[0]->id);
        }
        $model = $query->sortable()->paginate(15);
//        var_dump($model[0]->fault_type->name); die();

        return view('problem.index', compact('filter', 'model','data','shart'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delivery(){

        $id = $_GET['id'];
        $problem = Problem::where('id',$id)->first();
        $for_detail = For_detail::where('problem_id',$id)->first();

        $problem->department_id = $for_detail->dep_id;
        $problem->save();
        $for_detail->delete();
        $request = 'success';
        return response()->json([$request]);

    }

    public function select(Request $request){
//        $ids = $_GET['ids'];
        $ids = json_encode($request->ids);
//        $idd = $_GET['idd'];
        $idd = $request->idd;
        $request->session()->put('ids', $ids);
        $request->session()->put('idd', $idd);
        $request = 'success';
        return response()->json($request);
    }

    public function many($id){
        $prob =Problem::where('id',$id)->first();
        $problems = Problem::where('current_stage_id',$prob->current_stage_id)
            ->where('department_id',$prob->department_id)
            ->where('vehicle_model_id',$prob->vehicle_model_id)
            ->where('fault_type_id',$prob->fault_type_id)
            ->where('level_second_id',$prob->level_second_id)
            ->get();
        return view('problem.many', compact('problems', 'id'));
    }

    public function create()
    {
        $model = new Problem();
        return view('problem.create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'department_id' => 'required|integer',
            'dealer_id' => 'required|integer',
            'region_id' => 'required|integer',
            'level_second_id' => 'required|integer',
            'fault_type_id' => 'required|integer',
            'vehicle_model_id' => 'required|integer',
            'part_type' => 'nullable|max:50',
            'part_number' => 'nullable|max:10',
            'vin' => 'required|max:20',
            'description' => 'required',
            'problem_type_id' => 'required|integer',
            'attachment' => 'nullable|file|max:1024',
            'video_attachment' => 'nullable|file|max:2024',
        ];

        $user = Auth::user();
        if ($user->can('department')) {
            $rules['part_type'] = 'required|max:50';
            $rules['part_number'] = 'required|max:10';
        }

        $this->validate($request, $rules);
        $initial_stage = Stage::whereSequence(101)->firstOrFail();
        $model = new Problem();
        $model->current_stage_id = $initial_stage->id;
        $model->department_id = $request->department_id;
        $model->dealer_id = $request->dealer_id;
        $model->region_id = $request->region_id;
        $model->level_second_id = $request->level_second_id;
        $model->fault_type_id = $request->fault_type_id;
        $model->vehicle_model_id = $request->vehicle_model_id;
        $model->part_number = $request->part_number;
        $model->vin = $request->vin;
        $model->part_type = $request->part_type;
        $model->description = $request->description;
//        $model->contact_info = $request->contact_info;
        $model->problem_type_id = $request->problem_type_id;
        $model->has_penalty = false; //(boolean)$request->has_penalty;
        $model->status = Problem::STATUS_OPEN;
	    $model->created_by = Auth::user()->id;
	    $model->created_at = $request->created_at;
        $model->save();

        $file = $request->file('attachment');
	     $videofile = $request->file('video_attachment');
        if ($file /*or $videofile*/) {
	        $extension = $file->getClientOriginalExtension();
//	        $extension1 = $videofile->getClientOriginalExtension();
	        $filename = md5(uniqid(Auth::user()->id . time(), true)) . '.' . $extension;
//	        $filename1 = md5(uniqid(Auth::user()->id . time(), true)) . '.' . $extension1;
	        Storage::disk('uploads')->put($filename, File::get($file));
//	        Storage::disk('uploads')->put($filename1, File::get($videofile));
	        $model->attachment = url('uploads/' . $filename);
//	        $model->video_attachment = url('uploads/' . $filename1);
            $model->save();
        }
        // create problem action
        $action = new ProblemActions();
        $action->user_id = Auth::user()->id;
        $action->problem_id = $model->id;
        $action->stage_id = $initial_stage->id;
        $action->content = $request->description;
        $action->attachment = null;
        $action->accepted = null;
        $action->deadline_at = null;
        $action->completed = true;
        $action->save();
        // next stage
        $next_stage = Stage::where('id', '>', $model->current_stage_id)->first();
        $action_next = new ProblemActions();
        $action_next->user_id = Auth::user()->id;
        $action_next->problem_id = $model->id;
        $action_next->stage_id = $next_stage->id;
        $action_next->content = null;
        $action_next->attachment = null;
        $action_next->deadline_at = null;
        $action_next->accepted = null;
        $action_next->completed = false;
        $action_next->save();
        $model->current_stage_id = $next_stage->id;
        $model->save();
        // send an email to users
        $data['id'] = $model->id;
        $data['part_number'] = $model->part_number;
        $data['part_type'] = $model->part_type;
        $data['vin'] = $model->vin;
        $data['description'] = $model->description;
        $title = 'No reply!!! PRTS Warranty ' . $model->vin . ' created';

        $responsibleEmail = VehicleModel::findOrFail($model->vehicle_model_id);
        $department = Department::with('users')->findOrFail($model->department_id);
// add	
$staffEmails = User::where(['role'=>User::ROLE_EMPLOYEE])->get();

        $emails = [];
        $ccs = [
		'kobiljon.abdurasulov@uzautomotors.com',
		'muhiddin.abduqodirov@uzautomotors.com',
		'Numanjon.Atashev@uzautomotors.com',
		'Bakhadir.Abdullayev@uzautomotors.com'
		];
// add
	foreach ($staffEmails as $staff) $ccs[] = $staff->email;
	// add model responsible
	if($responsibleEmail->responsible_email) 		$ccs[]=$responsibleEmail->responsible_email;
	// add
	$ccs = array_unique($ccs);

        foreach ($department->users as $user) $emails[] = $user->email;
        try {
            if (count($emails)>0) {
                Mail::send('emails.prr', $data, function ($message) use ($title, $emails, $ccs) {
                    $message->subject($title)
                        ->to($emails)
			->cc($ccs)
                        ->replyTo('zafarbek.djurabayev@uzautomotors.com', 'Zafarbek');
                });
                Log::info($emails);
            } else {
                Log::info('Email not set');
            }
        } catch (\Exception $ex) {
            Log::error($emails);
            Log::error($ex->getMessage());
        }

        return redirect('problems/' . $model->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Problem::with(['stage', 'dealer', 'vehicleModel', 'department', 'problemType', 'completedProblemActions'])->findOrFail($id);
        $doAction = false;
        $user = Auth::user();
        // All the business logic here
        $pendingProblemAction = ProblemActions::with('stage')
            ->where('problem_id', '=', $model->id)
            ->where('stage_id', '=', $model->current_stage_id)
            ->whereCompleted(0)
            ->orderBy('created_at', 'desc')->first();

//        if ($model->stage->sequence != 999 && $pendingProblemAction) {

            if ($pendingProblemAction) {
            if ($pendingProblemAction->stage->owner == User::ROLE_SUPPLIER && $user->hasRole('department')) {
                $doAction = true;
            }
            if ($pendingProblemAction->stage->owner == User::ROLE_EMPLOYEE && !$user->hasRole('department') && !$user->hasRole('employee')) {
                $doAction = true;
            }
        }
        $sa = 1207;
        return view('problem.show', compact('model', 'pendingProblemAction', 'doAction', 'user','sa'));
    }
    public function shows()
    {
        $model = Problem::with(['stage', 'dealer', 'vehicleModel', 'department', 'problemType', 'completedProblemActions'])->get();
        $doAction = false;
        $user = Auth::user();
        // All the business logic here
        $pendingProblemAction = ProblemActions::with('stage')
            ->where('problem_id', '=', $model->id)
            ->where('stage_id', '=', $model->current_stage_id)
            ->whereCompleted(0)
            ->orderBy('created_at', 'desc')->first();

//        if ($model->stage->sequence != 999 && $pendingProblemAction) {

        if ($pendingProblemAction) {
            if ($pendingProblemAction->stage->owner == User::ROLE_SUPPLIER && $user->hasRole('department')) {
                $doAction = true;
            }
            if ($pendingProblemAction->stage->owner == User::ROLE_EMPLOYEE && !$user->hasRole('department') && !$user->hasRole('employee')) {
                $doAction = true;
            }
        }
        $sa = 1207;
        return view('problem.show', compact('model', 'pendingProblemAction', 'doAction', 'user','sa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Problem::findOrFail($id);
        return view('problem.edit', compact('model'));
    }

    public function group_problem(Request $request)
    {

        if ($request->sort != 'all'){



            $s= $request->session()->get('s');

            if ($s == $request->sort){
                $sort = 'ORDER BY '.$request->sort.' ASC';
                $request->session()->put('s',$request->sort);
            }
            else {
                $sort = 'ORDER BY '.$request->sort.' DESC';

                $request->session()->put('s',$request->sort);

            }


        }
        else{
            $sort = 'ORDER BY `soni` ASC';
        }

//        $sort = ($request->sort != 'all') ?  'ORDER BY '.$request->sort.' ASC': ' ORDER BY `soni` ASC';
//        $model = "
//        SELECT  * , departments.name as tsex, count(problems.id) as soni FROM problems
//        INNER join departments on departments.id = problems.department_id
//        GROUP BY problems.department_id
//        ORDER BY `problems`.`id` ASC
//        ";

        $model = "
        SELECT problems.id, departments.name depname, ft.name defname, ft.kod kod, count(problems.id) soni, lf.name lfname, ls.name lsname, vm.name vmname  FROM `problems`
        LEFT join departments on departments.id = problems.department_id
        LEFT join fault_types as ft on ft.id = problems.fault_type_id
        LEFT JOIN level_seconds as ls on ls.id = problems.level_second_id
        LEFT JOIN level_firsts as lf on lf.id = ls.level_first_id
        LEFT JOIN vehicle_models as vm on vm.id = problems.vehicle_model_id
        GROUP BY departments.id, ft.id, ls.id, lf.id, vm.id
        $sort 
        ";
        $model = DB::select($model);

//        $tus = DB::select($tus);
//        $tus = DB::select(DB::raw($tus));
//        print_r($tus); die();

        return view('problem.group_problem', compact('model'));

    }
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'department_id' => 'required|integer',
            'dealer_id' => 'required|integer',
            'region_id' => 'required|integer',
            'level_second_id' => 'nullable|integer',
            'fault_type_id' => 'required|integer',
            'vehicle_model_id' => 'required|integer',
            'part_type' => 'nullable|max:50',
            'part_number' => 'nullable|max:10',
            'vin' => 'required|max:20',
            'description' => 'required',
            'problem_type_id' => 'required|integer',
            'attachment' => 'nullable|file|max:1024',
        ];

        $user = Auth::user();
        if ($user->can('department')) {
            $rules['part_type'] = 'required|max:50';
            $rules['part_number'] = 'required|max:10';
        }

        $this->validate($request, $rules);
//        $initial_stage = Stage::whereSequence(101)->firstOrFail();
        $model = Problem::findOrFail($id);
//        $model->current_stage_id = $initial_stage->id;
        $model->department_id = $request->department_id;
        $model->dealer_id = $request->dealer_id;
        $model->region_id = $request->region_id;
        $model->level_second_id = $request->level_second_id;
        $model->fault_type_id = $request->fault_type_id;
        $model->vehicle_model_id = $request->vehicle_model_id;
        $model->part_number = $request->part_number;
        $model->vin = $request->vin;
        $model->part_type = $request->part_type;
        $model->description = $request->description;
//        $model->contact_info = $request->contact_info;
        $model->problem_type_id = $request->problem_type_id;
        $model->has_penalty = false; //(boolean)$request->has_penalty;
        $model->status = Problem::STATUS_OPEN;
        $model->created_by = Auth::user()->id;
        $model->created_at = $request->created_at;
        $model->save();
        return redirect('problems/' . $model->id);


//        return view('emailList.show',compact('model'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        if ($user->can('delete-problem')) {
            $model = Problem::findOrFail($id);
            if ($model->attachment) {
                $items = explode('/uploads/', $model->attachment);
                Storage::disk('uploads')->delete($items[1]);
            }
            $model->delete();
        }

        return redirect('problems');
    }

    public function report()
    {
        $user = Auth::user();
        $query = Problem::query();
        $query->with(['stage', 'department', 'problemType']);
        // by roles
        if ($user->hasRole('department')) {
            $query->where('department_id', '=', $user->departments[0]->id);
        }
        if ($user->hasRole('employee')) {
            $query->where('created_by', '=', $user->id);
        }
        $data = $query->orderBy('status')->orderBy('created_at', 'DESC')->get();
        $problemsArray = [];
        // Define the Excel spreadsheet headers
        $problemsArray[] = [
            trans('app.id'),
            trans('app.menu.models'),
            trans('app.problem.vin'),
            trans('app.problem.description'),
            trans('app.dealer.name'),
            trans('app.problem.department_id'),
            trans('app.placeholder.regions'),
            trans('app.problem.problem_type_id'),
            trans('app.menu.stages'),
            trans('app.problem.status'),
            trans('app.created_at'),
        ];

        // Convert each member of the returned collection into an array,
        // and append it to the payments array.

        foreach ($data as $problem) {
            $problemsArray[] = [
                $problem->id,
                $problem->vehicleModel->name,
                $problem->vin,
                $problem->description,
                $problem->dealer->name,
                $problem->department->name,
                $problem->region->name,
                $problem->problemType->name,
                $problem->stage->title,
                trans('app.problem.status_' . $problem->status),
                $problem->created_at,
            ];
        }
        // Generate and return the spreadsheet
        Excel::create('payments', function ($excel) use ($problemsArray) {
            // Set the spreadsheet title, creator, and description
            $excel->setTitle('PRTS');
            $excel->setCreator('SQE')->setCompany('UzAuto Motors');
            $excel->setDescription('Problem list');
            // Build the spreadsheet, passing in the payments array
            $excel->sheet('report', function ($sheet) use ($problemsArray) {
                $sheet->fromArray($problemsArray, null, 'A1', false, false);
            });

        })->download('xls');
    }

    public function levelsecond(Request $request = null){

        $data = Level_second::select('name','id')->where('level_first_id',$request->id)->get();
        return response()->json($data);

    }
}
