<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
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
        $data = Supplier::sortable()->paginate(15);
        return view('supplier.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new Supplier();
        return view('supplier.create', compact('model'));
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
            'name' => 'required|max:255',
            // 'duns' => 'required|unique:suppliers,duns',
            //'email' => 'required|email',
            'email' => 'required|emails',
        ]);

        $model = new Supplier();

        $model->name = $request->name;
        // $model->duns = $request->duns;
        $model->email = $request->email;

        $model->save();

        return view('supplier.show',compact('model'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Supplier::findOrFail($id);
        return view('supplier.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Supplier::findOrFail($id);
        return view('supplier.edit', compact('model'));
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
            'name' => 'required|max:255',
            // 'duns' => 'required|unique:suppliers,duns,'.$id,
            //'email' => 'required|email',
            'email' => 'required|emails',
        ]);

        $model = Supplier::findOrFail($id);

        $model->name = $request->name;
        // $model->duns = $request->duns;
        $model->email = $request->email;

        $model->save();

        return view('supplier.show',compact('model'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Supplier::findOrFail($id);
        $model->delete();
        return redirect('suppliers');
    }
}
