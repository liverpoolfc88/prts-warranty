<?php

namespace App\Http\Controllers;

use App\VehicleModel;
use Illuminate\Http\Request;

class VehicleModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = VehicleModel::sortable()->paginate(15);
        return view('vehicleModel.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new VehicleModel();
        return view('vehicleModel.create', compact('model'));
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
            'name' => 'required|max:50|unique:vehicle_models',
            'responsible_email' => 'nullable|max:100',
        ]);

        $model = new VehicleModel();
        $model->name = $request->name;
        $model->responsible_email = $request->responsible_email;
        $model->save();

        return view('vehicleModel.show',compact('model'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VehicleModel  $vehicleModel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = VehicleModel::findOrFail($id);
        return view('vehicleModel.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VehicleModel  $vehicleModel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = VehicleModel::findOrFail($id);
        return view('vehicleModel.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VehicleModel  $vehicleModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:50|unique:vehicle_models,name,'.$id,
            'responsible_email' => 'nullable|max:100',
        ]);

        $model = VehicleModel::findOrFail($id);
        $model->name = $request->name;
        $model->responsible_email = $request->responsible_email;
        $model->save();

        return view('vehicleModel.show',compact('model'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VehicleModel  $vehicleModel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = VehicleModel::findOrFail($id);
        $model->delete();
        return redirect('vehicle-models');
    }
}
