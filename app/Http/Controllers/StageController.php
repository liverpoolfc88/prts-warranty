<?php

namespace App\Http\Controllers;

use App\Stage;
use App\StageGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class StageController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:admin', ['except'=>'index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = StageGroup::with(['stages'=>function($q){ $q->orderBy('sequence'); }])->orderBy('sequence')->paginate(15);
        return view('stage.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new Stage();
        return view('stage.create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255|unique:stages,title',
            'sequence' => 'required|unique:stages,sequence',
            'stage_group_id' => 'required',
            'owner' => 'required',
        ]);

        $model = new Stage();

        $model->title = $request->title;
        $model->sequence = $request->sequence;
        $model->stage_group_id = $request->stage_group_id;

        $model->has_action = $request->has('has_action') ? true : false;
        $model->has_date = $request->has('has_date') ? true : false;
        $model->has_attachment = $request->has('has_attachment') ? true : false;
        $model->has_approval = $request->has('has_approval') ? true : false;
        $model->owner = $request->owner;

        $model->save();

        return view('stage.show',compact('model'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Stage::with('stageGroup')->findOrFail($id);
        return view('stage.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Stage::findOrFail($id);
        return view('stage.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'sequence' => 'required|unique:stages,sequence,'.$id,
            'stage_group_id' => 'required',
            'owner' => 'required',
        ]);

        $model = Stage::findOrFail($id);

        $model->title = $request->title;
        $model->sequence = $request->sequence;
        $model->stage_group_id = $request->stage_group_id;

        $model->has_action = $request->has('has_action') ? true : false;
        $model->has_date = $request->has('has_date') ? true : false;
        $model->has_attachment = $request->has('has_attachment') ? true : false;
        $model->has_approval = $request->has('has_approval') ? true : false;
        $model->owner = $request->owner;

        $model->save();

        return view('stage.show',compact('model'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id == 1) throw new AccessDeniedHttpException();
        $model = Stage::findOrFail($id);
        $model->delete();
        return redirect('stages');
    }
}
