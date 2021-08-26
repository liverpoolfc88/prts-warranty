<?php

namespace App\Http\Controllers;

use App\VehicleModel;
use Illuminate\Http\Request;
use App\Email_list;

class EmaillistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Email_list::paginate(15);
        return view('emailList.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new Email_list();
        return view('emailList.create', compact('model'));
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
            'email' => 'nullable|max:100',
        ]);

        $model = new Email_list();
        $model->name = $request->name;
        $model->email = $request->email;
        $model->save();

        return view('emailLIst.show',compact('model'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Email_list::findOrFail($id);
        return view('emailList.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Email_list::findOrFail($id);
        return view('emailList.edit', compact('model'));
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
            'email' => 'nullable|max:100',
        ]);

        $model = Email_list::findOrFail($id);
        $model->name = $request->name;
        $model->email = $request->email;
        $model->save();

        return view('emailList.show',compact('model'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Email_list::findOrFail($id);
        $model->delete();
        return redirect('email-list');
    }
}
