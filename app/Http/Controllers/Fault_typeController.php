<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fault_type;

class Fault_typeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Fault_type::paginate(15);
        return view('faultType.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new Fault_type();
        return view('faultType.create', compact('model'));
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
            'kod' => 'required|string',
        ]);

        $model = new Fault_type();
        $model->name = $request->name;
        $model->kod = $request->kod;
        $model->save();

        return view('faultType.show',compact('model'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Fault_type::findOrFail($id);
        return view('faultType.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Fault_type::findOrFail($id);
        return view('faultType.edit', compact('model'));
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
            'kod' => 'required|integer',
        ]);

        $model = Fault_type::findOrFail($id);
        $model->name = $request->name;
        $model->kod = $request->kod;
        $model->save();

        return view('faultType.show',compact('model'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Fault_type::findOrFail($id);
        $model->delete();
        return redirect('fault_type');
    }
}
