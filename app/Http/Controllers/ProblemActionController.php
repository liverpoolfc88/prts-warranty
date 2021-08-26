<?php

namespace App\Http\Controllers;

use App\Email_list;
use App\For_detail;
use App\Problem;
use App\Department;
use App\ProblemActions;
use App\Stage;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Monolog\Handler\IFTTTHandler;

class ProblemActionController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'content' => 'required_without_all:accepted,not_accepted|string:5000',
            'attachment' => 'nullable|file|max:1024',
            'deadline_at' => 'nullable|date|date_format:Y-m-d',
            //'accepted' => 'nullable|accepted',
        ]);

        $rejected = false;

        $model_action = ProblemActions::with('stage')->findOrFail($id);

        if ($model_action->stage->has_approval) {
            if ($request->get('accepted')) {
                $model_action->accepted = 1;
            } else {
                $model_action->accepted = 0;
                $rejected = true;
            }
            $model_action->accepted = $request->get('accepted') ? true : false;
            $model_action->content = $request->get('content');
        } else {
            $model_action->content = $request->get('content');
            $model_action->deadline_at = $request->get('deadline_at');

            //$model_action->attachment = $request->get('attachment');
            $file = $request->file('attachment');
            if ($file) {
                $extension = $file->getClientOriginalExtension();
                $filename = md5(uniqid(Auth::user()->id . time(), true)) . '.' . $extension;
                Storage::disk('uploads')->put($filename, File::get($file));
                $model_action->attachment = url('uploads/' . $filename);
            }
        }

        $model_action->completed = 1;
        $model_action->user_id = Auth::user()->id;
        $model_action->save();

        $problem = Problem::findOrFail($model_action->problem_id);
        // goto next stage
        if ($rejected) {
            // find first in group
            $next_stage = Stage::where('stage_group_id', '=', $model_action->stage->stage_group_id)->orderBy('sequence')->first();
        } else {
            $next_stage = Stage::where('sequence', '>', $model_action->stage->sequence)->orderBy('sequence')->first();
        }

        if ($next_stage) {
            $action_next = new ProblemActions();
            $action_next->user_id = Auth::user()->id;
            $action_next->problem_id = $model_action->problem_id;
            $action_next->stage_id = $next_stage->id;
            $action_next->content = null;
            $action_next->attachment = null;
            $action_next->deadline_at = null;
            $action_next->accepted = null;
            $action_next->completed = false;
            $action_next->save();

            $problem->current_stage_id = $next_stage->id;
            $problem->save();
            $content = $action_next->content;


            if ($model_action->stage_id == 4) {
                Mail::send('emails.action_notifier', [
                    'vin' => $problem->vin,
                    'department' => $problem->department->name,
                    'model' => $problem->vehicleModel->name,
                    'desc' => $problem->description,
                    'date' => $problem->created_at
                ],
                    function ($message) use ($content) {
                        $message->subject($content . ' Muammoga o\'zgartirish kiritildi')
					        ->to('Kamoldin.djurabayev@uzautomotors.com');
//                            ->to('Sardor.Dexkonov@uzautomotors.com');
                    });
            }
            return redirect('problems');
        }
        $problem->status = Problem::STATUS_CLOSE;
        $problem->save();
        return back()->withInput();
    }

    public function request(){

        $id = $_GET['id'];

        $problem = Problem::where('id',$id)->first();

        $model = Department::where('name','A/C')
        ->first();

        $email_list = Email_list::all();
        $list = [];

        foreach ($email_list as $keyy => $vall) {
            $list[] = $vall->email;
        }
        $list[] = ($model->email) ? $model->email : '';


        Mail::send('emails.action_wpac', [
            'xabar' =>'muommosi bo`yicha detal kerak' ,
//            'xabar' =>'Test uchun Test uchun Test uchun' ,
            'vin' => $problem->vin,
            'department' => $problem->department->name,
            'model' => $problem->vehicleModel->name,
            'desc' => $problem->description,
            'date' => $problem->created_at
        ],
            function ($message) use ($list) {
                $message->subject('Detalsiz muommo xal bo`lmaydi')
                    ->to($list);
            });
        $for_detail = new For_detail();
        $for_detail->problem_id = $problem->id;
        $for_detail->dep_id = $problem->department_id;
        $for_detail->save();

        $problem->department_id = $model->id;
        $problem->save();



        $request = 'success';
        return response()->json([$request]);
    }

    public function reject($id){

        $problem = Problem::where('id',$id)->first();
        $action_5 = ProblemActions::where('problem_id', $id)->where('stage_id', 5);
        $action_5->delete();
        $problem->current_stage_id = 4;
        $problem->status = 0;
        $problem->save();
            $action_4 = ProblemActions::where('problem_id', $id)->where('stage_id',4)->first();
            $action_4->completed = 0;
            $action_4->attachment = null;
            $action_4->content = null;
            $action_4->deadline_at = null;
            $action_4->save();
        return redirect('problems');
    }

    public function status()
    {
        $dat = date("Y-m-d H:i:s", time() - 86400);
        $d = date("2020-11-29 00:00:00");

        $model = Problem::
        where('email_status', null)
            ->where('created_at', '<', $dat)
            ->where('created_at', '>', $d)
            ->get();

        foreach ($model as $key => $val) {

            $email_model = explode(';', $val->vehicleModel->responsible_email);
            $email_dep = explode(';', $val->department->email);
            $email_list = Email_list::all();
            $list = [];

            foreach ($email_list as $keyy => $value) {
                $list[] = $value->email;
            }


            $email = array_merge($email_dep, $email_model);

            Mail::send('emails.action_status', [
                'vin' => $val->vin,
                'department' => $val->department->name,
                'model' => $val->vehicleModel->name,
                'desc' => $val->description,
                'date' => $val->created_at
            ],
                function ($message) use ($email) {
                    $message->subject('Status bo`yicha natija bo`lmadi ')
                        ->to($email);
                });

            $val->email_status = 1;
            $val->save();

        }

    }
}
