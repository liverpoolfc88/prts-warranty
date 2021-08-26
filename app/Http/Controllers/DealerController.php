<?php

namespace App\Http\Controllers;

use App\Dealer;
use Illuminate\Http\Request;

class DealerController extends Controller
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
        $data = Dealer::sortable()->paginate(15);
        return view('dealer.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new Dealer();
        return view('dealer.create', compact('model'));
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
            'name' => 'required|max:191|unique:dealers',
            'address' => 'nullable|max:191',
            'contact' => 'nullable|max:191',
        ]);

        $model = new Dealer();

        $model->name = $request->name;
        $model->address = $request->address;
        $model->contact = $request->contact;

        $model->save();

        return view('dealer.show',compact('model'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Dealer::findOrFail($id);
        return view('dealer.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Dealer::findOrFail($id);
        return view('dealer.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:191|unique:dealers,name,'.$id,
            'address' => 'nullable|max:191',
            'contact' => 'nullable|max:191',
        ]);

        $model = Dealer::findOrFail($id);

        $model->name = $request->name;
        $model->address = $request->address;
        $model->contact = $request->contact;

        $model->save();

        return view('dealer.show',compact('model'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Dealer::findOrFail($id);
        $model->delete();
        return redirect('dealers');
    }
}
