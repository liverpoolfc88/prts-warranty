<?php

namespace App\Http\Controllers;

use App\Role;
use App\Department;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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
    public function index(Request $request)
    {

//            $name = ($_GET['name']) ? $_GET['name'] : '';


        $me = Auth::user()->id;

        $data = User::with(['departments'])
//            ->where('id','<>',$me)
//            ->where('name','<>','admin')
            ->where('name', 'like', '%'.$request->get('name').'%')
            ->sortable()
            ->paginate(15);
        return view('user.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new User();
        $roles = Role::where('name','<>','department')->get()->pluck('name', 'id');
        $departments = Department::all()->pluck('name', 'id');
        return view('user.create', compact('model','roles','departments'));
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
            'name' => 'required|max:255|unique:users,name',
            'email' => 'required|max:255|email|unique:users,email',
            'phone_number' => 'required|max:100',
            'role' => 'required|integer',
            'role_id' => 'required_if:role,0|integer',
            'department_id' => 'required_if:role,1|integer',
            'password' => 'required|min:6',
        ]);

        $model = new User();

        $model->name = $request->name;
        $model->email = $request->email;
        $model->phone_number = $request->phone_number;
        $model->role = $request->role;
        if($request->role == User::ROLE_SUPPLIER ){
            //$model->roles()->attach($request->role_id);
            $role = Role::where('name','=','department')->firstOrFail();
            $request->role_id = $role->id;
        }

        $model->password = bcrypt($request->password);
        $model->save();
        // attach role
        $model->roles()->sync($request->role_id);

        if($request->role == User::ROLE_SUPPLIER ){
            $model->departments()->sync($request->department_id);
        }

        return view('user.show',compact('model'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = User::with(['roles','departments'])->findOrFail($id);
        return view('user.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = User::with('departments')->findOrFail($id);
        $roles = Role::where('name','<>','department')->get()->pluck('name', 'id');
        $departments = Department::all()->pluck('name', 'id');
        return view('user.edit', compact('model','roles','departments'));
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
            'name' => 'required|max:255|unique:users,name,'.$id,
            'email' => 'required|max:255|email|unique:users,email,'.$id,
            'phone_number' => 'required|max:100',
            'role' => 'required|integer',
            'role_id' => 'required_if:role,0|integer',
            'department_id' => 'required_if:role,1|integer',
            'password' => 'nullable|min:6',
        ]);

        $model = User::with(['departments','roles'])->findOrFail($id);

        $model->name = $request->name;
        $model->email = $request->email;
        $model->phone_number = $request->phone_number;
        $model->role = $request->role;
        if($request->role == User::ROLE_SUPPLIER ){
            $role = Role::where('name','=','department')->firstOrFail();
            $request->role_id = $role->id;
        }


        if($request->has('password')) $model->password = bcrypt($request->password);
        $model->save();
        // attach role
        $model->roles()->sync($request->role_id);

        if($request->role == User::ROLE_SUPPLIER ){
            $model->departments()->sync($request->department_id);
        }
        else{
            $model->departments()->detach();
        }

        return view('user.show',compact('model'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = User::findOrFail($id);
        $model->delete();
        return redirect('users');
    }
}
