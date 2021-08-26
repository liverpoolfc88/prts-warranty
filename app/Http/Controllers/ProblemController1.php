<?php

namespace App\Http\Controllers;

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
        $filter = StageGroup::with('stages')->get();
        $query = Problem::query();
        $query->with(['stage', 'region','department', 'problemType']);
        // by filters
        if ($request->has('id')) {
            $query->where('id', '=', $request->id);
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
        $data = $query->sortable()->paginate(15);

        return view('problem.index', compact('filter', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
            ->whereCompleted(0)->orderBy('created_at', 'desc')->first();
//        if ($model->stage->sequence != 999 && $pendingProblemAction) {
        if ($pendingProblemAction) {
            if ($pendingProblemAction->stage->owner == User::ROLE_SUPPLIER && $user->hasRole('department')) {
                $doAction = true;
            }
            if ($pendingProblemAction->stage->owner == User::ROLE_EMPLOYEE && !$user->hasRole('department') && !$user->hasRole('employee')) {
                $doAction = true;
            }
        }

        return view('problem.show', compact('model', 'pendingProblemAction', 'doAction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
}
