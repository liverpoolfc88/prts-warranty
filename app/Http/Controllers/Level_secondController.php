<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Level_second;

class Level_secondController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Level_second::paginate(15);
        return view('level2.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new Level_second();
        return view('level2.create', compact('model'));
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
            'name' => 'required',
            'level_first_id' => 'required|integer',
        ]);

        $model = new Level_second();
        $model->name = $request->name;
        $model->level_first_id = $request->level_first_id;
        $model->save();

        return view('level2.show',compact('model'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Level_second::findOrFail($id);
        return view('level2.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Level_second::findOrFail($id);
        return view('level2.edit', compact('model'));
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
            'name' => 'required',
            'level_first_id' => 'required|integer',
        ]);

        $model = Level_second::findOrFail($id);
        $model->name = $request->name;
        $model->level_first_id = $request->level_first_id;
        $model->save();

        return view('level2.show',compact('model'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Level_second::findOrFail($id);
        $model->delete();
        return redirect('level2');
    }
}
