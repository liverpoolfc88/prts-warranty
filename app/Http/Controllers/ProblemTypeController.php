<?php

namespace App\Http\Controllers;

use App\ProblemType;
use Illuminate\Http\Request;

class ProblemTypeController extends Controller
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
        $data = ProblemType::orderBy('name')->paginate(15);
        return view('problemType.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new ProblemType();
        return view('problemType.create', compact('model'));
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
            'name' => 'required|max:191|unique:problem_types,name',
        ]);

        $model = new ProblemType();

        $model->name = $request->name;
        $model->save();

        //return view('problemType.show',compact('model'));
        return redirect('problem-types');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = ProblemType::findOrFail($id);
        return view('problemType.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = ProblemType::findOrFail($id);
        return view('problemType.edit', compact('model'));
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
            'name' => 'required|max:191|unique:problem_types,name,'.$id,
        ]);

        $model = ProblemType::findOrFail($id);

        $model->name = $request->name;
        $model->save();

        //return view('problemType.show',compact('model'));
        return redirect('problem-types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = ProblemType::findOrFail($id);
        $model->delete();
        return redirect('problem-types');
    }
}
