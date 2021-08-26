<?php

namespace App\Http\Controllers;

use App\Stage;
use App\StageGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class StageGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = StageGroup::orderBy('sequence')->paginate(15);
        return view('stageGroup.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new StageGroup();
        $max = DB::table('stage_groups')
            ->select(DB::raw('max(sequence) as seq_max'))
            ->first();
        $model->sequence = $max ? $max->seq_max + 1 : 1;
        return view('stageGroup.create', compact('model'));
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
        ]);

        $model = new StageGroup();

        $model->title = $request->title;
        $model->sequence = $request->sequence;
        $model->save();

        return view('stageGroup.show',compact('model'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = StageGroup::with(['stages'=>function($query){ $query->orderBy('sequence'); }])->findOrFail($id);
        return view('stageGroup.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = StageGroup::with(['stages'=>function($query){ $query->orderBy('sequence'); }])->findOrFail($id);
        return view('stageGroup.edit', compact('model'));
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
            'title' => 'required|max:255|unique:stage_groups,title,'.$id,
            'sequence' => 'required|unique:stage_groups,sequence,'.$id,
        ]);

        $model = StageGroup::findOrFail($id);

        $model->title = $request->title;
        $model->sequence = $request->sequence;
        $model->save();

        return redirect('stage-groups');
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

        Stage::where('stage_group_id', '=', $id)->delete();

        $model = StageGroup::findOrFail($id);
        $model->delete();

        return redirect('stage-groups');
    }
}
